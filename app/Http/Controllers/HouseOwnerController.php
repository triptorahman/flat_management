<?php

namespace App\Http\Controllers;

use App\Models\HouseOwner;
use App\Models\Building;
use App\Http\Requests\HouseOwnerRequest;
use Illuminate\Support\Facades\DB;
use Exception;


class HouseOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houseOwners = HouseOwner::with('building')->paginate(10);
        return view('admin.house_owner.index', compact('houseOwners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.house_owner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HouseOwnerRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Create the house owner
                $houseOwnerData = $request->getHouseOwnerData();
                $houseOwner = HouseOwner::create($houseOwnerData);
                
                // Create the building associated with the house owner
                $buildingData = $request->getBuildingData();
                $buildingData['house_owner_id'] = $houseOwner->id;
                
                Building::create($buildingData);
            });
            
            return redirect()
                ->route('house-owners.index')
                ->with('success', 'House owner and building have been created successfully.');
                
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the house owner and building. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HouseOwner $houseOwner)
    {
        // Load the building relationship
        $houseOwner->load('building');
        
        return view('admin.house_owner.show', compact('houseOwner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HouseOwner $houseOwner)
    {
        // Load the building relationship
        $houseOwner->load('building');
        
        return view('admin.house_owner.edit', compact('houseOwner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HouseOwnerRequest $request, HouseOwner $houseOwner)
    {
        try {
            DB::transaction(function () use ($request, $houseOwner) {
                // Update the house owner
                $houseOwnerData = $request->getHouseOwnerData();
                $houseOwner->update($houseOwnerData);
                
                // Update or create the building
                $buildingData = $request->getBuildingData();
                
                if ($houseOwner->building) {
                    // Update existing building
                    $houseOwner->building->update($buildingData);
                } else {
                    // Create new building if it doesn't exist
                    $buildingData['house_owner_id'] = $houseOwner->id;
                    Building::create($buildingData);
                }
            });
            
            return redirect()
                ->route('house-owners.index')
                ->with('success', 'House owner and building have been updated successfully.');
                
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the house owner and building. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HouseOwner $houseOwner)
    {
        try {
            DB::transaction(function () use ($houseOwner) {
                // Load the building relationship to check if it exists
                $houseOwner->load('building');
                
                // Delete the associated building first (if exists)
                if ($houseOwner->building) {
                    $houseOwner->building->delete();
                }
                
                // Delete the house owner
                $houseOwner->delete();
            });
            
            return redirect()
                ->route('house-owners.index')
                ->with('success', 'House owner and associated building have been deleted successfully.');
                
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'An error occurred while deleting the house owner. Please try again.');
        }
    }
}
