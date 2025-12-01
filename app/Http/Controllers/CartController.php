<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];
        
        foreach ($cart as $id => $details) {
            $meal = Meal::find($id);
            if ($meal) {
                $items[] = [
                    'meal' => $meal,
                    'quantity' => $details['quantity'],
                    'subtotal' => $meal->price * $details['quantity']
                ];
                $total += $meal->price * $details['quantity'];
            }
        }
        
        return view('cart.index', compact('items', 'total'));
    }
    
    /**
     * Add meal to cart
     */
    public function add(Request $request, Meal $meal)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);
        
        $cart = session()->get('cart', []);
        
        // Check if meal already in cart
        if (isset($cart[$meal->id])) {
            $cart[$meal->id]['quantity'] += $request->quantity;
        } else {
            $cart[$meal->id] = [
                'quantity' => $request->quantity,
                'restaurant_id' => $meal->restaurant_id
            ];
        }
        
        // Ensure all items are from the same restaurant
        $restaurantIds = array_unique(array_column($cart, 'restaurant_id'));
        if (count($restaurantIds) > 1) {
            return back()->with('error', 'You can only order from one restaurant at a time. Please clear your cart first.');
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Meal added to cart!');
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$meal->id])) {
            $cart[$meal->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            return back()->with('success', 'Cart updated!');
        }
        
        return back()->with('error', 'Item not found in cart');
    }
    
    /**
     * Remove meal from cart
     */
    public function remove(Meal $meal)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$meal->id])) {
            unset($cart[$meal->id]);
            session()->put('cart', $cart);
            
            return back()->with('success', 'Item removed from cart!');
        }
        
        return back()->with('error', 'Item not found in cart');
    }
    
    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        
        return back()->with('success', 'Cart cleared!');
    }
}