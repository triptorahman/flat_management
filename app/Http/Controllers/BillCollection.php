<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

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
                $previousBill->due_amount = 0;
                $previousBill->paid_at = $request->payment_date;
                $previousBill->save();
            }

            $bill->status = 'paid';
            $bill->due_amount = 0;
            $bill->paid_at = $request->payment_date;
        } else {
            $bill->status = 'paid';
            $bill->paid_at = $request->payment_date;
        }

        $bill->save();

        $totalPaid = $includeDueAmount ?
            number_format($bill->amount + ($includeDueAmount ? 0 : $bill->due_amount), 2) :
            number_format($bill->amount, 2);

        $message = $includeDueAmount ?
            "Payment of $" . number_format($bill->amount + $bill->due_amount, 2) . " collected successfully (including due amount)." :
            "Payment of $" . number_format($bill->amount, 2) . " collected successfully. Due amount remains unpaid.";

        return redirect()->route('house-owner.bill-collections.index')
            ->with('success', $message);
    }
}
