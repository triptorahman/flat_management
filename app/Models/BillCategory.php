<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BillCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'house_owner_id',
    ];

    /**
     * Get the house owner that owns the bill category.
     */
    public function houseOwner(): BelongsTo
    {
        return $this->belongsTo(HouseOwner::class);
    }

    /**
     * Get the bills for the bill category.
     */
    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
