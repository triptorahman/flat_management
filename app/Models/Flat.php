<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flat extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'house_owner_id',
        'flat_number',
        'owner_name',
        'owner_contact',
        'owner_email',
    ];

    /**
     * Get the building that the flat belongs to.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the house owner that owns the flat.
     */
    public function houseOwner()
    {
        return $this->belongsTo(HouseOwner::class);
    }

    /**
     * Get the tenants associated with the flat.
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Get the bills associated with the flat.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
