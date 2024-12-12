<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSignup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BusinessLoginController extends Controller
{
   
        public function loginBusiness(Request $request)
        {
            try {
                // Validate input
                $request->validate([
                    'user_name' => 'required|string',
                    'password' => 'required|string',
                ]);
    
                // Check if the business user exists
                $business = BusinessSignup::where('user_name', $request->user_name)->first();
   
                if (!$business || !Hash::check($request->password, $business->password)) {
                    return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
                }
    
                $admin = Auth::guard('admins')->user();

                if ($admin) {
                    session(['admin_role' => $admin->role]); // Store admin role in session
                }
    
                // Store business user details in session
                session(['business_id' => $business->business_id, 'user_name' => $business->user_name]);
    
                // Redirect to dashboard
                return redirect('/dash-board')->with('success', 'Welcome back, ' . $business->user_name . '!');
            } catch (\Exception $e) {
                \Log::error('Login error: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString()); // Log stack trace for debugging
                return redirect()->back()->with('error', 'An error occurred. Please try again.');
            }
        }
    
    
}
