<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders for this restaurant
     */
    public function index(Request $request)
    {
        $restaurantId = session('restaurant_id');
        
        $query = Order::where('restaurant_id', $restaurantId)
            ->with('orderItems.meal');
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Sort by newest first
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Count by status for tabs
        $statusCounts = [
            'all' => Order::where('restaurant_id', $restaurantId)->count(),
            'pending' => Order::where('restaurant_id', $restaurantId)->where('status', 'pending')->count(),
            'confirmed' => Order::where('restaurant_id', $restaurantId)->where('status', 'confirmed')->count(),
            'preparing' => Order::where('restaurant_id', $restaurantId)->where('status', 'preparing')->count(),
            'ready' => Order::where('restaurant_id', $restaurantId)->where('status', 'ready')->count(),
            'delivered' => Order::where('restaurant_id', $restaurantId)->where('status', 'delivered')->count(),
            'cancelled' => Order::where('restaurant_id', $restaurantId)->where('status', 'cancelled')->count(),
        ];
        
        return view('restaurant.orders.index', compact('orders', 'statusCounts'));
    }
    
    /**
     * Display specific order details
     */
    public function show(Order $order)
    {
        // Middleware already verified ownership
        $order->load('orderItems.meal');
        
        return view('restaurant.orders.show', compact('order'));
    }
    
    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled'
        ]);
        
        $data = ['status' => $request->status];
        
        // Set timestamps based on status
        if ($request->status === 'confirmed' && !$order->confirmed_at) {
            $data['confirmed_at'] = now();
        }
        
        if ($request->status === 'delivered' && !$order->delivered_at) {
            $data['delivered_at'] = now();
            $data['payment_status'] = 'paid'; // Auto-mark as paid when delivered (COD)
        }
        
        $order->update($data);
        
        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }
}