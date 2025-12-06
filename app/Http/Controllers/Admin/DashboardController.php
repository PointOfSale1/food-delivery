<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Models\Meal;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_restaurants' => Restaurant::count(),
            'active_restaurants' => Restaurant::where('status', 'active')->count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
            'todays_orders' => Order::whereDate('created_at', today())->count(),
            'todays_revenue' => Order::whereDate('created_at', today())->where('status', 'delivered')->sum('total'),
        ];
        
        // Recent restaurants
        $recentRestaurants = Restaurant::latest()->take(5)->get();
        
        // Recent orders
        $recentOrders = Order::with('restaurant')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recentRestaurants', 'recentOrders'));
    }
}