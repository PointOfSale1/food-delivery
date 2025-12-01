<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display home page with all restaurants
     */
    public function index(Request $request)
    {
        // Get search query if exists
        $search = $request->input('search');
        
        // Get all active restaurants
        $query = Restaurant::where('status', 'active');
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $restaurants = $query->paginate(12);
        
        return view('home', compact('restaurants', 'search'));
    }
}