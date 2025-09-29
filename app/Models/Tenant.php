<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'building_id',
        'flat_id',
        'assigned_by_admin_id',
    ];

    /**
     * Get the flat that the tenant belongs to.
     */
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    /**
     * Get the building that the tenant belongs to.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the admin who assigned this tenant.
     */
    public function assignedByAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_by_admin_id');
    }
}
