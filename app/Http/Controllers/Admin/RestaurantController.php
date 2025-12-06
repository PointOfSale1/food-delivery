<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display all restaurants
     */
    public function index()
    {
        $restaurants = Restaurant::withCount('orders', 'meals')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.restaurants.index', compact('restaurants'));
    }
    
    /**
     * Show create restaurant form
     */
    public function create()
    {
        return view('admin.restaurants.create');
    }
    
    /**
     * Store new restaurant
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:restaurants,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->except('logo');
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('restaurants', 'public');
        }
        
        $data['status'] = 'active';
        
        Restaurant::create($data);
        
        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant created successfully! Credentials have been set.');
    }
    
    /**
     * Show edit restaurant form
     */
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }
    
    /**
     * Update restaurant
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:restaurants,email,' . $restaurant->id,
            'password' => 'nullable|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);
        
        $data = $request->except(['logo', 'password']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($restaurant->logo) {
                Storage::disk('public')->delete($restaurant->logo);
            }
            
            $data['logo'] = $request->file('logo')->store('restaurants', 'public');
        }
        
        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = $request->password; // Model will hash it
        }
        
        $restaurant->update($data);
        
        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant updated successfully!');
    }
    
    /**
     * Delete restaurant
     */
    public function destroy(Restaurant $restaurant)
    {
        // Delete logo
        if ($restaurant->logo) {
            Storage::disk('public')->delete($restaurant->logo);
        }
        
        $restaurant->delete();
        
        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant deleted successfully!');
    }
    
    /**
     * View restaurant details
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['orders' => function($query) {
            $query->latest()->take(10);
        }, 'meals', 'categories']);
        
        $stats = [
            'total_orders' => $restaurant->orders()->count(),
            'total_revenue' => $restaurant->orders()->where('status', 'delivered')->sum('total'),
            'total_meals' => $restaurant->meals()->count(),
            'total_categories' => $restaurant->categories()->count(),
        ];
        
        return view('admin.restaurants.show', compact('restaurant', 'stats'));
    }
}