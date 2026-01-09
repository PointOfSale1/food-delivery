<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;
use App\Models\Meal;
use App\Models\Category;

 /* Authorization */ 
class RestaurantOwner
{
    
    //Handle an incoming request.
    //Ensures restaurant can only access THEIR OWN data
    //This prevents Restaurant A from viewing/editing Restaurant B's orders/meals
    // answer the question: Does this data belong to the logged-in restaurant?
     
    public function handle(Request $request, Closure $next): Response
    {
        $restaurantId = session('restaurant_id');
        
        // Check order ownership
        if ($request->route('order')) {
            $order = $request->route('order');
            if ($order->restaurant_id != $restaurantId) {
                abort(403, 'Unauthorized: This order does not belong to your restaurant');
            }
        }
        
        // Check meal ownership
        if ($request->route('meal')) {
            $meal = $request->route('meal');
            if ($meal->restaurant_id != $restaurantId) {
                abort(403, 'Unauthorized: This meal does not belong to your restaurant');
            }
        }
        
        // Check category ownership
        if ($request->route('category')) {
            $category = $request->route('category');
            if ($category->restaurant_id != $restaurantId) {
                abort(403, 'Unauthorized: This category does not belong to your restaurant');
            }
        }

        return $next($request);
    }
}