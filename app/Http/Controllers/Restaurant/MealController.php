<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MealController extends Controller
{
    /**
     * Display all meals
     */
    public function index()
    {
        $restaurantId = session('restaurant_id');
        
        $meals = Meal::where('restaurant_id', $restaurantId)
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->paginate(20);
        
        return view('restaurant.meals.index', compact('meals'));
    }
    
    /**
     * Show create meal form
     */
    public function create()
    {
        $restaurantId = session('restaurant_id');
        
        // Get restaurant's categories
        $categories = Category::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        return view('restaurant.meals.create', compact('categories'));
    }
    
    /**
     * Store new meal
     */
    public function store(Request $request)
    {
        $restaurantId = session('restaurant_id');
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        // Verify category belongs to this restaurant
        $category = Category::findOrFail($request->category_id);
        if ($category->restaurant_id != $restaurantId) {
            return back()->with('error', 'This category does not belong to your restaurant')
                ->withInput();
        }
        
        $data = [
            'restaurant_id' => $restaurantId,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'price' => $request->price,
            'sort_order' => $request->sort_order ?? 0,
            'is_available' => $request->has('is_available') ? true : false,
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('meals', 'public');
        }
        
        Meal::create($data);
        
        return redirect()->route('restaurant.meals.index')
            ->with('success', 'Meal created successfully!');
    }
    
    /**
     * Show edit meal form
     */
    public function edit(Meal $meal)
    {
        $restaurantId = session('restaurant_id');
        
        // Middleware already verified ownership
        $categories = Category::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        return view('restaurant.meals.edit', compact('meal', 'categories'));
    }
    
    /**
     * Update meal
     */
    public function update(Request $request, Meal $meal)
    {
        $restaurantId = session('restaurant_id');
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        
        // Verify new category also belongs to this restaurant
        $category = Category::findOrFail($request->category_id);
        if ($category->restaurant_id != $restaurantId) {
            return back()->with('error', 'This category does not belong to your restaurant')
                ->withInput();
        }
        
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'price' => $request->price,
            'sort_order' => $request->sort_order ?? 0,
            'is_available' => $request->has('is_available') ? true : false,
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($meal->image) {
                Storage::disk('public')->delete($meal->image);
            }
            
            $data['image'] = $request->file('image')->store('meals', 'public');
        }
        
        $meal->update($data);
        
        return redirect()->route('restaurant.meals.index')
            ->with('success', 'Meal updated successfully!');
    }
    
    /**
     * Delete meal
     */
    public function destroy(Meal $meal)
    {
        // Delete image
        if ($meal->image) {
            Storage::disk('public')->delete($meal->image);
        }
        
        $meal->delete();
        
        return redirect()->route('restaurant.meals.index')
            ->with('success', 'Meal deleted successfully!');
    }
}