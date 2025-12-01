<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display dashboard home
     */
    public function index()
    {
        $restaurantId = session('restaurant_id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        // Statistics
        $stats = [
            'pending_orders' => Order::where('restaurant_id', $restaurantId)
                ->where('status', 'pending')
                ->count(),
                
            'todays_orders' => Order::where('restaurant_id', $restaurantId)
                ->whereDate('created_at', today())
                ->count(),
                
            'todays_revenue' => Order::where('restaurant_id', $restaurantId)
                ->whereDate('created_at', today())
                ->where('status', 'delivered')
                ->sum('total'),
                
            'total_meals' => $restaurant->meals()->count(),
        ];
        
        // Recent orders
        $recentOrders = Order::where('restaurant_id', $restaurantId)
            ->with('orderItems')
            ->latest()
            ->take(5)
            ->get();
        
        return view('restaurant.dashboard', compact('restaurant', 'stats', 'recentOrders'));
    }
    
    /**
     * Show profile page
     */
    public function profile()
    {
        $restaurantId = session('restaurant_id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        return view('restaurant.profile', compact('restaurant'));
    }
    
    /**
     * Update restaurant profile
     */
    public function updateProfile(Request $request)
    {
        $restaurantId = session('restaurant_id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:restaurants,email,' . $restaurantId,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        $data = $request->except(['password', 'password_confirmation', 'logo']);
        
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
        
        // Update session name if changed
        if ($request->name !== session('restaurant_name')) {
            session(['restaurant_name' => $request->name]);
        }
        
        return back()->with('success', 'Profile updated successfully!');
    }
}