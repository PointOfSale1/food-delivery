<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// it run before request reach the controller
class AdminAuth
{
    //Handle an incoming request.
    // This middleware ensures that only logged-in admins can access admin routes.
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to access admin panel');
        }

        // Allow the request to continue to the next controller
        return $next($request);
    }
}
