<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'house_owner_id',
        'bill_category_id',
        'month',
        'amount',
        'due_amount',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'month' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
    ];

    /**
     * Get the flat that the bill belongs to.
     */
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    /**
     * Get the house owner that the bill belongs to.
     */
    public function houseOwner()
    {
        return $this->belongsTo(HouseOwner::class);
    }

    /**
     * Get the bill category.
     */
    public function billCategory()
    {
        return $this->belongsTo(BillCategory::class);
    }

    /**
     * Get the bill details (line items).
     */
    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }

    /**
     * Calculate total amount from bill details.
     */
    public function getTotalAmountAttribute()
    {
        return $this->billDetails->sum('amount') + $this->due_amount;
    }
}
