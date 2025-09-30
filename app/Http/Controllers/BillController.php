<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Tenant;
use App\Models\Flat;
use App\Models\BillCategory;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BillGeneratedNotification;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houseOwner = Auth::guard('house_owner')->user();
        $building = Building::find($houseOwner->id);

        $tenants = Tenant::where('building_id', $building->id)->get();


        return view('house-owner.bill.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $houseOwner = Auth::guard('house_owner')->user();
        $flats = Flat::where('house_owner_id', $houseOwner->id)
            ->orderBy('flat_number')
            ->get();

        
        $billCategories = BillCategory::where('house_owner_id', $houseOwner->id)
            ->orderBy('name')
            ->get();

        $selectedTenantId = $request->get('tenant_id');
        $selectedFlatId = $request->get('flat_id');
        $selectedTenant = null;
        $selectedFlat = null;
        $dueAmount = 0;

        if ($selectedTenantId) {
            $selectedTenant = Tenant::find($selectedTenantId);
        }

        if ($selectedFlatId) {
            $selectedFlat = Flat::where('id', $selectedFlatId)
                ->where('house_owner_id', $houseOwner->id)
                ->first();

            if ($selectedFlat) {
                
                $dueAmount = Bill::where('flat_id', $selectedFlatId)
                    ->where('status', 'unpaid')
                    ->sum('amount');

            }
        }

        return view('house-owner.bill.create', compact(
            'flats',
            'billCategories',
            'selectedTenant',
            'selectedFlat',
            'selectedFlatId',
            'dueAmount'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $houseOwner = Auth::guard('house_owner')->user();

                $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'month' => 'required|date_format:Y-m',
            'status' => 'required|in:unpaid,paid',
            'notes' => 'nullable|string|max:1000',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:bill_categories,id',
        ]);


        $categories = $request->categories ?? [];
        $amounts = $request->amounts ?? [];
        $descriptions = $request->descriptions ?? [];


        foreach ($categories as $categoryId) {
            if (!isset($amounts[$categoryId]) || !is_numeric($amounts[$categoryId]) || $amounts[$categoryId] < 0) {
                return back()->withErrors(['amounts' => 'Please enter valid amounts for all selected categories.'])->withInput();
            }
        }


        $monthDate = date('Y-m-01', strtotime($request->month . '-01'));

        $existingBill = Bill::where('flat_id', $request->flat_id)
            ->where('house_owner_id', $houseOwner->id)
            ->whereYear('month', date('Y', strtotime($monthDate)))
            ->whereMonth('month', date('m', strtotime($monthDate)))
            ->first();

        if ($existingBill) {
            return back()
                ->withErrors(['month' => 'A bill for this flat already exists for ' . date('F Y', strtotime($monthDate)) . '. Please choose a different month or edit the existing bill.'])
                ->withInput();
        }


        $totalAmount = 0;
        foreach ($categories as $categoryId) {
            $totalAmount += $amounts[$categoryId];
        }

        try {
            $bill = DB::transaction(function () use ($request, $houseOwner, $monthDate, $totalAmount, $categories, $amounts, $descriptions) {
                
                $bill = Bill::create([
                    'flat_id' => $request->flat_id,
                    'house_owner_id' => $houseOwner->id,
                    'bill_category_id' => $request->categories[0],
                    'month' => $monthDate,
                    'amount' => $totalAmount,
                    'status' => 'unpaid',
                    'notes' => $request->notes,
                    'paid_at' => null,
                ]);

                
                foreach ($categories as $categoryId) {
                    
                    $billCategory = BillCategory::where('id', $categoryId)
                        ->where('house_owner_id', $houseOwner->id)
                        ->firstOrFail();

                    $bill->billDetails()->create([
                        'bill_category_id' => $categoryId,
                        'amount' => $amounts[$categoryId],
                        'description' => $descriptions[$categoryId] ?? null,
                    ]);
                }

                return $bill;
            });

            // Send email notification to tenant
            $flat = Flat::with('tenant')->find($request->flat_id);
            if ($flat && $flat->tenant && $flat->tenant->email) {
                try {
                    // Calculate due amount for email
                    $dueAmount = Bill::where('flat_id', $flat->id)
                        ->where('status', 'unpaid')
                        ->where('month', '<', $bill->month)
                        ->sum('amount');
                    
                    Mail::to($flat->tenant->email)->send(
                        new BillGeneratedNotification($bill->load(['billDetails.billCategory', 'flat', 'houseOwner']), $flat->tenant, $dueAmount)
                    );
                    
                    Log::info('Bill notification email sent to tenant: ' . $flat->tenant->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send bill notification email: ' . $e->getMessage());
                    // Don't fail the bill creation if email fails
                }
            }

            $successMessage = 'Bill created successfully with ' . count($categories) . ' categories!';
            
            if ($flat && $flat->tenant) {
                if ($flat->tenant->email) {
                    $successMessage .= ' Email notification sent to ' . $flat->tenant->name . ' (' . $flat->tenant->email . ').';
                } else {
                    $successMessage .= ' Note: No email sent - tenant does not have an email address on file.';
                }
            } else {
                $successMessage .= ' Note: No email sent - no tenant assigned to this flat.';
            }

            return redirect()->route('house-owner.bills.index')
                ->with('success', $successMessage);
        } catch (\Exception $e) {

            Log::error('Bill creation failed: ' . $e->getMessage());

            return back()
                ->withErrors(['error' => 'Failed to create bill. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Check if bill exists for given flat and month
     */
    public function checkExisting(Request $request)
    {
        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $houseOwner = Auth::guard('house_owner')->user();
        $monthDate = date('Y-m-01', strtotime($request->month . '-01'));

        $existingBill = Bill::where('flat_id', $request->flat_id)
            ->where('house_owner_id', $houseOwner->id)
            ->whereYear('month', date('Y', strtotime($monthDate)))
            ->whereMonth('month', date('m', strtotime($monthDate)))
            ->first();

        return response()->json([
            'exists' => $existingBill ? true : false,
            'bill_id' => $existingBill ? $existingBill->id : null,
            'message' => $existingBill ? 'Bill already exists for ' . date('F Y', strtotime($monthDate)) : 'No existing bill found'
        ]);
    }

}
