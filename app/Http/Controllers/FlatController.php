<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flat;
use App\Http\Requests\FlatRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $building = auth('house_owner')->user()->building;
        $flats = $building->flats()->withCount('tenants')->paginate(10);

        return view('house-owner.flat.index', compact('flats', 'building'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $building = auth('house_owner')->user()->building;

        if (!$building) {
            return redirect()
                ->route('house-owner.flats.index')
                ->with('error', 'You must have a building assigned before creating flats.');
        }

        return view('house-owner.flat.create', compact('building'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlatRequest $request)
    {
        try {
            $building = auth('house_owner')->user()->building;

            // Use the getFlatData method from FlatRequest
            $flatData = $request->getFlatData();
            $flatData['building_id'] = $building->id;
            $flatData['house_owner_id'] = auth('house_owner')->id();

            Flat::create($flatData);

            return redirect()
                ->route('house-owner.flats.index')
                ->with('success', 'Flat has been created successfully.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the flat. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Flat $flat)
    {
        // Ensure the flat belongs to the authenticated house owner
        if ($flat->house_owner_id !== auth('house_owner')->id()) {
            abort(403, 'Unauthorized access to this flat.');
        }

        $flat->load(['building', 'tenants', 'bills']);

        return view('house-owner.flat.show', compact('flat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flat $flat)
    {
        // Ensure the flat belongs to the authenticated house owner
        if ($flat->house_owner_id !== auth('house_owner')->id()) {
            abort(403, 'Unauthorized access to this flat.');
        }

        $building = auth('house_owner')->user()->building;

        return view('house-owner.flat.edit', compact('flat', 'building'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FlatRequest $request, Flat $flat)
    {
        try {
            // Ensure the flat belongs to the authenticated house owner
            if ($flat->house_owner_id !== auth('house_owner')->id()) {
                abort(403, 'Unauthorized access to this flat.');
            }

            // Use the getFlatData method from FlatRequest
            $flatData = $request->getFlatData();
            $flat->update($flatData);

            return redirect()
                ->route('house-owner.flats.index')
                ->with('success', 'Flat has been updated successfully.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the flat. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flat $flat)
    {
        try {
            // Ensure the flat belongs to the authenticated house owner
            if ($flat->house_owner_id !== auth('house_owner')->id()) {
                abort(403, 'Unauthorized access to this flat.');
            }

            DB::transaction(function () use ($flat) {
                // Delete associated tenants and bills if any
                $flat->tenants()->delete();
                $flat->bills()->delete();

                // Delete the flat
                $flat->delete();
            });

            return redirect()
                ->route('house-owner.flats.index')
                ->with('success', 'Flat and all associated data have been deleted successfully.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'An error occurred while deleting the flat. Please try again.');
        }
    }

    public function getFlats($buildingId)
    {
        $flats = Flat::where('building_id', $buildingId)
            ->select('id', 'flat_number')
            ->where('available', 'yes')
            ->get();

        return response()->json($flats);
    }
}
