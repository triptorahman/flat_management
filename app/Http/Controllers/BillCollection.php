<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BillCollectedNotification;

class BillCollection extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houseOwner = Auth::guard('house_owner')->user();

        $bills = Bill::whereHas('flat', function ($query) use ($houseOwner) {
            $query->where('house_owner_id', $houseOwner->id);
        })
            ->with(['flat.tenant', 'billDetails.billCategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('house-owner.bill-collection.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show the form for collecting payment for a specific bill.
     */
    public function collect(Bill $bill)
    {
        $houseOwner = Auth::guard('house_owner')->user();

        // Verify the bill belongs to the authenticated house owner
        if ($bill->flat->house_owner_id !== $houseOwner->id) {
            abort(403, 'Unauthorized access to this bill.');
        }

        $bill->load(['flat.tenant', 'billDetails.billCategory']);
        
        // Calculate dynamic due amount from previous unpaid bills
        $dueAmount = Bill::where('flat_id', $bill->flat_id)
            ->where('status', 'unpaid')
            ->where('month', '<', $bill->month)
            ->sum('amount');
        
        // Add due amount as dynamic property
        $bill->due_amount = $dueAmount;

        return view('house-owner.bill-collection.collect', compact('bill'));
    }

    /**
     * Process payment for a specific bill.
     */
    public function updatePayment(Request $request, Bill $bill)
    {
        $houseOwner = Auth::guard('house_owner')->user();

        if ($bill->flat->house_owner_id !== $houseOwner->id) {
            abort(403, 'Unauthorized access to this bill.');
        }

        $request->validate([
            'include_due_amount' => 'required|boolean',
            'payment_date' => 'required|date',
        ]);

        if ($bill->status === 'paid') {
            return redirect()->route('house-owner.bill-collections.index')
                ->with('error', 'This bill has already been paid.');
        }

        $includeDueAmount = $request->boolean('include_due_amount');

        if ($includeDueAmount) {
            $previousUnpaidBills = Bill::where('flat_id', $bill->flat_id)
                ->where('status', 'unpaid')
                ->where('month', '<', $bill->month)
                ->get();

            foreach ($previousUnpaidBills as $previousBill) {
                $previousBill->status = 'paid';
                $previousBill->paid_at = $request->payment_date;
                $previousBill->save();
            }

            $bill->status = 'paid';
            $bill->paid_at = $request->payment_date;
        } else {
            $bill->status = 'paid';
            $bill->paid_at = $request->payment_date;
        }

        $bill->save();

        // Calculate total amount paid and prepare email data
        if ($includeDueAmount) {
            $previousDueAmount = Bill::where('flat_id', $bill->flat_id)
                ->where('status', 'paid')
                ->where('month', '<', $bill->month)
                ->where('paid_at', $request->payment_date)
                ->sum('amount');
            
            $totalAmount = $bill->amount + $previousDueAmount;
            $message = "Payment of $" . number_format($totalAmount, 2) . " collected successfully (including previous due amounts).";
        } else {
            $totalAmount = $bill->amount;
            $message = "Payment of $" . number_format($bill->amount, 2) . " collected successfully. Previous due amounts remain unpaid.";
        }

        // Send email notifications
        $this->sendPaymentNotifications($bill, $totalAmount, $request->payment_date, $includeDueAmount);
        
        // Enhance success message with email notification info
        $emailInfo = '';
        if ($bill->flat->tenant && $bill->flat->tenant->email) {
            $emailInfo = ' Email notifications sent to tenant, house owner, and admin.';
        } else {
            $emailInfo = ' Email notifications sent to house owner and admin only (tenant has no email).';
        }

        return redirect()->route('house-owner.bill-collections.index')
            ->with('success', $message . $emailInfo);
    }

    /**
     * Send payment notification emails to tenant, house owner, and admin
     */
    private function sendPaymentNotifications(Bill $bill, $totalAmount, $paymentDate, $includedDueAmount)
    {
        try {
            // Load necessary relationships
            $bill->load(['flat.tenant', 'billDetails.billCategory', 'houseOwner']);
            $tenant = $bill->flat->tenant;

            if (!$tenant) {
                Log::warning('No tenant found for bill payment notification. Bill ID: ' . $bill->id);
                return;
            }

            // 1. Send email to tenant (if tenant has email)
            if ($tenant->email) {
                try {
                    Mail::to($tenant->email)->send(
                        new BillCollectedNotification($bill, $tenant, $totalAmount, $paymentDate, $includedDueAmount, 'tenant')
                    );
                    Log::info('Payment notification email sent to tenant: ' . $tenant->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment notification to tenant: ' . $e->getMessage());
                }
            }

            // 2. Send email to house owner (if house owner has email)
            $houseOwner = $bill->houseOwner;
            if ($houseOwner && $houseOwner->email) {
                try {
                    Mail::to($houseOwner->email)->send(
                        new BillCollectedNotification($bill, $tenant, $totalAmount, $paymentDate, $includedDueAmount, 'house_owner')
                    );
                    Log::info('Payment notification email sent to house owner: ' . $houseOwner->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment notification to house owner: ' . $e->getMessage());
                }
            }

            // 3. Send email to admin (get admin email from config or first user)
            try {
                $adminEmail = config('mail.admin_email') ?? env('ADMIN_EMAIL');
                if (!$adminEmail) {
                    // Fallback to first user if no admin email configured
                    $admin = User::first();
                    $adminEmail = $admin ? $admin->email : null;
                }
                
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(
                        new BillCollectedNotification($bill, $tenant, $totalAmount, $paymentDate, $includedDueAmount, 'admin')
                    );
                    Log::info('Payment notification email sent to admin: ' . $adminEmail);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send payment notification to admin: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            Log::error('Error in sendPaymentNotifications: ' . $e->getMessage());
        }
    }
}
