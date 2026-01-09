<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

//Checks if restaurant is logged in
class RestaurantAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('restaurant_id')) {
            return redirect()->route('restaurant.login')
                ->with('error', 'Please login to access dashboard');
        }

        return $next($request);
    }
}