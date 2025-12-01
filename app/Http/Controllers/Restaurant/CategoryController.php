<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $restaurantId = session('restaurant_id');
        
        $categories = Category::where('restaurant_id', $restaurantId)
            ->withCount('meals')
            ->orderBy('sort_order')
            ->get();
        
        return view('restaurant.categories.index', compact('categories'));
    }
    
    /**
     * Show create category form
     */
    public function create()
    {
        return view('restaurant.categories.create');
    }
    
    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $restaurantId = session('restaurant_id');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        Category::create([
            'restaurant_id' => $restaurantId,
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        
        return redirect()->route('restaurant.categories.index')
            ->with('success', 'Category created successfully!');
    }
    
    /**
     * Show edit category form
     */
    public function edit(Category $category)
    {
        // Middleware already verified ownership
        return view('restaurant.categories.edit', compact('category'));
    }
    
    /**
     * Update category
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        
        return redirect()->route('restaurant.categories.index')
            ->with('success', 'Category updated successfully!');
    }
    
    /**
     * Delete category
     */
    public function destroy(Category $category)
    {
        // Check if category has meals
        if ($category->meals()->count() > 0) {
            return back()->with('error', 'Cannot delete category with meals. Please delete or move meals first.');
        }
        
        $category->delete();
        
        return redirect()->route('restaurant.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}