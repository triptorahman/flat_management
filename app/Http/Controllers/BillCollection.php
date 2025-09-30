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
        
        $bills = Bill::whereHas('flat', function($query) use ($houseOwner) {
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

        return view('house-owner.bill-collection.collect', compact('bill'));
    }
}
