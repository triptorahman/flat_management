<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Building;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with(['flat', 'building'])->paginate(10);
        return view('admin.tenant.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buildings = Building::select('id', 'name')->get();

        return view('admin.tenant.create', compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'contact' => 'nullable|string|max:20',
            'building_id' => 'required|exists:buildings,id',
            'flat_id' => 'required|exists:flats,id',
        ]);

        try {
            // Add the current authenticated admin's ID
            $validatedData['assigned_by_admin_id'] = Auth::id();

            // Create the tenant
            $tenant = Tenant::create($validatedData);

            // Update the flat's availability status to 'no'
            $flat = $tenant->flat;
            if ($flat) {
                $flat->available = 'no';
                $flat->save();
            }

            // Redirect with success message
            return redirect()->route('tenants.index')
                ->with('success', 'Tenant created successfully! ' . $tenant->name . ' has been assigned to the flat.');

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Tenant creation failed: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create tenant. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::with(['flat', 'building', 'assignedByAdmin'])->findOrFail($id);
        return view('admin.tenant.show', compact('tenant'));
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
        $tenant = Tenant::findOrFail($id);

        // Before deleting the tenant, update the flat's availability status to 'yes'
        $flat = $tenant->flat;
        if ($flat) {
            $flat->available = 'yes';
            $flat->save();
        }

        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant deleted successfully!');
    }
}
