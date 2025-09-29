<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HouseOwner extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'house_owner'; // important for the custom guard

    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function building()
    {
        return $this->hasOne(Building::class);
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    public function billCategories()
    {
        return $this->hasMany(BillCategory::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
