<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Tenant;
use App\Models\Flat;
use App\Models\BillCategory;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // Get flats belonging to this house owner
        $flats = Flat::where('house_owner_id', $houseOwner->id)
            ->orderBy('flat_number')
            ->get();
            
        // Get bill categories belonging to this house owner
        $billCategories = BillCategory::where('house_owner_id', $houseOwner->id)
            ->orderBy('name')
            ->get();

        // Get selected tenant and flat if provided
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
            
            // Calculate due amount from previous unpaid bills
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
            'due_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:unpaid,paid',
            'notes' => 'nullable|string|max:1000',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:bill_categories,id',
        ]);

        // Custom validation for amounts corresponding to selected categories
        $categories = $request->categories ?? [];
        $amounts = $request->amounts ?? [];
        $descriptions = $request->descriptions ?? [];

        // Validate that we have amounts for all selected categories
        foreach ($categories as $categoryId) {
            if (!isset($amounts[$categoryId]) || !is_numeric($amounts[$categoryId]) || $amounts[$categoryId] < 0) {
                return back()->withErrors(['amounts' => 'Please enter valid amounts for all selected categories.'])->withInput();
            }
        }

        // Verify the flat belongs to this house owner
        $flat = Flat::where('id', $request->flat_id)
            ->where('house_owner_id', $houseOwner->id)
            ->firstOrFail();

        // Convert month to proper date format (first day of the month)
        $monthDate = date('Y-m-01', strtotime($request->month . '-01'));

        // Check if bill already exists for this flat and month
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

        // Calculate total amount from selected categories
        $totalAmount = 0;
        foreach ($categories as $categoryId) {
            $totalAmount += $amounts[$categoryId];
        }

        // Create the main bill record
        $bill = Bill::create([
            'flat_id' => $request->flat_id,
            'house_owner_id' => $houseOwner->id,
            'bill_category_id' => $request->categories[0], // Use first category as primary
            'month' => $monthDate,
            'amount' => $totalAmount,
            'due_amount' => $request->due_amount ?? 0,
            'status' => $request->status,
            'notes' => $request->notes,
            'paid_at' => $request->status === 'paid' ? now() : null,
        ]);

        // Create bill details for each selected category
        foreach ($request->categories as $categoryId) {
            // Verify each category belongs to this house owner
            $billCategory = BillCategory::where('id', $categoryId)
                ->where('house_owner_id', $houseOwner->id)
                ->firstOrFail();

            $bill->billDetails()->create([
                'bill_category_id' => $categoryId,
                'amount' => $amounts[$categoryId],
                'description' => $descriptions[$categoryId] ?? null,
            ]);
        }

        return redirect()->route('house-owner.bills.index')
            ->with('success', 'Bill created successfully with ' . count($request->categories) . ' categories!');
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

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        $houseOwner = Auth::guard('house_owner')->user();

        // Ensure the bill belongs to the authenticated house owner
        if ($bill->house_owner_id !== $houseOwner->id) {
            abort(403);
        }

        $bill->load(['flat', 'billCategory']);

        return view('house-owner.bill.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        $houseOwner = Auth::guard('house_owner')->user();

        // Ensure the bill belongs to the authenticated house owner
        if ($bill->house_owner_id !== $houseOwner->id) {
            abort(403);
        }

        // Get flats belonging to this house owner
        $flats = Flat::where('house_owner_id', $houseOwner->id)
            ->orderBy('flat_number')
            ->get();
            
        // Get bill categories belonging to this house owner
        $billCategories = BillCategory::where('house_owner_id', $houseOwner->id)
            ->orderBy('name')
            ->get();

        return view('house-owner.bill.edit', compact('bill', 'flats', 'billCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        $houseOwner = Auth::guard('house_owner')->user();

        // Ensure the bill belongs to the authenticated house owner
        if ($bill->house_owner_id !== $houseOwner->id) {
            abort(403);
        }

        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'bill_category_id' => 'required|exists:bill_categories,id',
            'month' => 'required|date_format:Y-m',
            'amount' => 'required|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:unpaid,paid',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Verify the flat belongs to this house owner
        $flat = Flat::where('id', $request->flat_id)
            ->where('house_owner_id', $houseOwner->id)
            ->firstOrFail();
            
        // Verify the bill category belongs to this house owner
        $billCategory = BillCategory::where('id', $request->bill_category_id)
            ->where('house_owner_id', $houseOwner->id)
            ->firstOrFail();

        // Convert month to proper date format (first day of the month)
        $monthDate = date('Y-m-01', strtotime($request->month . '-01'));

        $bill->update([
            'flat_id' => $request->flat_id,
            'bill_category_id' => $request->bill_category_id,
            'month' => $monthDate,
            'amount' => $request->amount,
            'due_amount' => $request->due_amount ?? 0,
            'status' => $request->status,
            'notes' => $request->notes,
            'paid_at' => $request->status === 'paid' && $bill->status !== 'paid' ? now() : 
                        ($request->status === 'unpaid' ? null : $bill->paid_at),
        ]);

        return redirect()->route('house-owner.bills.show', $bill)
            ->with('success', 'Bill updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $houseOwner = Auth::guard('house_owner')->user();

        // Ensure the bill belongs to the authenticated house owner
        if ($bill->house_owner_id !== $houseOwner->id) {
            abort(403);
        }

        $bill->delete();

        return redirect()->route('house-owner.bills.index')
            ->with('success', 'Bill deleted successfully!');
    }
}
