<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show admin login form ... redirect if already logged in
    public function showLogin()
    {
        // Redirect if already logged in
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    // Handle admin login ... check validity and store session
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Check if admin exists in database
        $admin = Admin::where('email', $request->email)->first();
        
        // Check password validity
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Store admin info in session
            session([
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
            ]);
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . $admin->name . '!');
        }
        
        return back()->withErrors(['email' => 'Invalid credentials.'])
            ->withInput($request->only('email'));
    }

    // Handle admin logout ... clear session
    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_email']);
        
        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully!');
    }
}