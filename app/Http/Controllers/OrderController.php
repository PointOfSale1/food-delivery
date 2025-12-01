<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }
        
        // Calculate totals
        $subtotal = 0;
        $items = [];
        $restaurantId = null;
        
        foreach ($cart as $id => $details) {
            $meal = Meal::find($id);
            if ($meal) {
                $itemSubtotal = $meal->price * $details['quantity'];
                $items[] = [
                    'meal' => $meal,
                    'quantity' => $details['quantity'],
                    'subtotal' => $itemSubtotal
                ];
                $subtotal += $itemSubtotal;
                $restaurantId = $meal->restaurant_id;
            }
        }
        
        $deliveryFee = 5.00; // Fixed delivery fee
        $total = $subtotal + $deliveryFee;
        
        return view('checkout', compact('items', 'subtotal', 'deliveryFee', 'total', 'restaurantId'));
    }
    
    /**
     * Store new order
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_address' => 'required|string',
            'city' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }
        
        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = 0;
            $restaurantId = null;
            
            foreach ($cart as $id => $details) {
                $meal = Meal::findOrFail($id);
                $subtotal += $meal->price * $details['quantity'];
                $restaurantId = $meal->restaurant_id;
            }
            
            $deliveryFee = 5.00;
            $total = $subtotal + $deliveryFee;
            
            // Create order
            $order = Order::create([
                'restaurant_id' => $restaurantId,
                'user_id' => auth()->id(), // null if guest
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_address' => $request->delivery_address,
                'city' => $request->city,
                'notes' => $request->notes,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
            ]);
            
            // Create order items
            foreach ($cart as $id => $details) {
                $meal = Meal::findOrFail($id);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'meal_id' => $meal->id,
                    'meal_name' => $meal->name,
                    'meal_price' => $meal->price,
                    'quantity' => $details['quantity'],
                    'subtotal' => $meal->price * $details['quantity'],
                ]);
            }
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('orders.confirmation', $order)->with('success', 'Order placed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
    
    /**
     * Show order confirmation
     */
    public function confirmation(Order $order)
    {
        $order->load('orderItems.meal', 'restaurant');
        
        return view('orders.confirmation', compact('order'));
    }
    
    /**
     * Show user's order history (requires login)
     */
    public function myOrders()
    {
        $orders = auth()->user()->orders()->with('restaurant')->latest()->paginate(10);
        
        return view('orders.my-orders', compact('orders'));
    }
}