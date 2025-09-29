<?php

namespace App\Http\Controllers;

use App\Models\BillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BillCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billCategories = BillCategory::where('house_owner_id', Auth::id())
            ->with('bills')
            ->orderBy('name')
            ->get();

        return view('house-owner.bill-category.index', compact('billCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('house-owner.bill-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bill_categories')->where(function ($query) {
                    return $query->where('house_owner_id', Auth::id());
                }),
            ],
        ], [
            'name.unique' => 'You already have a category with this name.',
        ]);

        $billCategory = BillCategory::create([
            'name' => $request->name,
            'house_owner_id' => Auth::id(),
        ]);

        return redirect()
            ->route('house-owner.bill-categories.index')
            ->with('success', 'Bill category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillCategory $billCategory)
    {
        // Ensure the bill category belongs to the authenticated house owner
        if ($billCategory->house_owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this bill category.');
        }

        $billCategory->load('bills');

        return view('house-owner.bill-category.edit', compact('billCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillCategory $billCategory)
    {
        // Ensure the bill category belongs to the authenticated house owner
        if ($billCategory->house_owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this bill category.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bill_categories')->where(function ($query) {
                    return $query->where('house_owner_id', Auth::id());
                })->ignore($billCategory->id),
            ],
        ], [
            'name.unique' => 'You already have a category with this name.',
        ]);

        $billCategory->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('house-owner.bill-categories.show', $billCategory)
            ->with('success', 'Bill category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillCategory $billCategory)
    {
        // Ensure the bill category belongs to the authenticated house owner
        if ($billCategory->house_owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this bill category.');
        }

        // Check if the category has associated bills
        if ($billCategory->bills()->count() > 0) {
            return redirect()
                ->route('house-owner.bill-categories.index')
                ->with('error', 'Cannot delete category that has bills associated with it. Please reassign or delete the bills first.');
        }

        $categoryName = $billCategory->name;
        $billCategory->delete();

        return redirect()
            ->route('house-owner.bill-categories.index')
            ->with('success', "Bill category '{$categoryName}' deleted successfully!");
    }
}
