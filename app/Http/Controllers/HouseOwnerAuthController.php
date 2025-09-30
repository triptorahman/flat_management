<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Flat;
use App\Models\Tenant;

class HouseOwnerAuthController extends Controller
{
    /**
     * Show the house owner login form.
     */
    public function showLoginForm()
    {
        return view('house-owner.auth.login');
    }

    /**
     * Handle house owner login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::guard('house_owner')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('house-owner.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Handle house owner logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('house_owner')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('house-owner.login')
            ->with('status', 'You have been successfully logged out.');
    }

    /**
     * Show the house owner dashboard.
     */
    public function dashboard()
    {
        $houseOwner = Auth::guard('house_owner')->user();
        $building = $houseOwner->building;

        // Calculate flat statistics
        $totalFlats = Flat::where('house_owner_id', $houseOwner->id)->count();
        
        $occupiedFlats = Flat::where('house_owner_id', $houseOwner->id)
            ->whereHas('tenant')
            ->count();
            
        $availableFlats = $totalFlats - $occupiedFlats;
        
        $stats = [
            'total_flats' => $totalFlats,
            'occupied_flats' => $occupiedFlats,
            'available_flats' => $availableFlats,
        ];
        
        return view('house-owner.dashboard', compact('building', 'stats'));
    }

    /**
     * Show the house owner's building details.
     */
    public function building()
    {
        $houseOwner = Auth::guard('house_owner')->user();
        $building = $houseOwner->building; // Get the building relationship
        
        return view('house-owner.building', compact('building'));
    }
}