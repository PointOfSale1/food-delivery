<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display restaurant details with categories
     */
    public function show(Restaurant $restaurant)
    {
        // Check if restaurant is active
        if ($restaurant->status !== 'active') {
            abort(404, 'Restaurant not found');
        }
        
        // Load active categories with their active meals
        $categories = $restaurant->categories()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['meals' => function($query) {
                $query->where('is_available', true)->orderBy('sort_order');
            }])
            ->get();
        
        return view('restaurants.show', compact('restaurant', 'categories'));
    }
}