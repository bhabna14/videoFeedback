<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('business-login'); // Create a Blade view for admin login
    }

    public function login(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Attempt to authenticate the admin
        if (Auth::guard('admins')->attempt($request->only('user_name', 'password'))) {
            // Redirect to the intended route or dashboard if no intended route is set
            return redirect()->intended('/admin/dash-board');
        }
    
        // If authentication fails, redirect back with an error message
        return redirect()->back()->with('error', 'Invalid credentials.');
    }
    

    public function logout()
    {
        Auth::guard('admins')->logout();
        return redirect()->url('business-login');
    }

    public function showDashboard()
    {
        $businessName = Auth::guard('admins')->user()->business_name ?? 'User'; // Default to 'User' if business_name is null
        return view('dash-board', compact('businessName'));
    }
    

}
