<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'house_owner_id',
    ];

    /**
     * Get the house owner that owns the building.
     */
    public function houseOwner()
    {
        return $this->belongsTo(HouseOwner::class);
    }

    /**
     * Get all flats in this building.
     */
    public function flats()
    {
        return $this->hasMany(Flat::class);
    }
}
