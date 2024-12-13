<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class SuperAdminController extends Controller
{
    public function businessRegister()
    {
        return view('sign-up');
    }

   
    public function saveBusinessRegister(Request $request)
    {
        try {
            // Validation logic for Admin table
            $request->validate([
                'business_name' => 'required|string|max:255',
                'mobile_number' => 'required|string|max:15|unique:admins,mobile_number',
                'email' => 'required|email|max:255|unique:admins,email',
                'user_name' => 'required|string|max:255|unique:admins,user_name',
                'password' => 'required|string|min:8',
            ]);
    
            // Generate random business ID
            $business_id = 'BUSINESS' . rand(100000, 999999);
    
            // Save the data in Admin table
            Admin::create([
                'business_id' => $business_id,
                'business_name' => $request->business_name,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'user_name' => $request->user_name,
                'password' => bcrypt($request->password),
                'role' => 'admin',
            ]);
    
            // Redirect to the dashboard with success message
            return redirect('admin/business-login')->with('success', 'Business registered successfully!');
    
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error while registering business: ', ['exception' => $e]);
    
            // Redirect back with error message
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
}
