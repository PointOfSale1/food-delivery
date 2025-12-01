<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display meals in a specific category
     */
    public function index(Restaurant $restaurant, Category $category)
    {
        // Verify category belongs to this restaurant
        if ($category->restaurant_id !== $restaurant->id) {
            abort(404);
        }
        
        // Get active meals in this category
        $meals = $category->meals()
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->get();
        
        return view('meals.index', compact('restaurant', 'category', 'meals'));
    }
    
    /**
     * Display specific meal details
     */
    public function show(Meal $meal)
    {
        // Check if meal is available
        if (!$meal->is_available) {
            abort(404, 'Meal not available');
        }
        
        // Load relationships
        $meal->load('restaurant', 'category');
        
        return view('meals.show', compact('meal'));
    }
}