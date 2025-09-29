<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'bill_category_id',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the bill that the detail belongs to.
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    /**
     * Get the bill category.
     */
    public function billCategory()
    {
        return $this->belongsTo(BillCategory::class);
    }
}