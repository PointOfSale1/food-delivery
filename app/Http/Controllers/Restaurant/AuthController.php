<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        // Redirect if already logged in
        if (session()->has('restaurant_id')) {
            return redirect()->route('restaurant.dashboard');
        }
        
        return view('restaurant.auth.login');
    }
     // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Find restaurant by email
        $restaurant = Restaurant::where('email', $request->email)->first();
        
        // Check credentials
        if ($restaurant && Hash::check($request->password, $restaurant->password)) {
            
            // Check if restaurant is active
            if ($restaurant->status !== 'active') {
                return back()->withErrors(['email' => 'Your restaurant account is inactive. Please contact support.']);
            }
            
            // Store restaurant info in session
            session([
                'restaurant_id' => $restaurant->id,
                'restaurant_name' => $restaurant->name,
                'restaurant_email' => $restaurant->email,
            ]);
            
            return redirect()->route('restaurant.dashboard')->with('success', 'Welcome back, ' . $restaurant->name . '!');
        }
        
        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }
    
    // Handle logout
    public function logout()
    {
        // Clear restaurant session
        session()->forget(['restaurant_id', 'restaurant_name', 'restaurant_email']);
        
        return redirect()->route('restaurant.login')->with('success', 'Logged out successfully!');
    }
}