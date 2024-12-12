<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\BusinessUnit;



class BusinessUnitController extends Controller
{
    public function showBusinessUnit(){

        $businessName = Auth::guard('admins')->user()->business_name ?? 'User'; 

        return view('admin.add-business-unit', compact('businessName')); 

    }

    public function saveBusinessUnit(Request $request)
    {
        // Validation rules
        $request->validate([
            'business_unit_name' => 'required|string|max:255',
            'business_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mobile_number' => 'required|digits_between:10,15',
            'whatsapp_number' => 'nullable|digits_between:10,15',
            'user_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'locality' => 'nullable|string|max:255',
            'pincode' => 'nullable|digits:6',
            'city' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'full_address' => 'nullable|string',
        ]);
    
        try {
            // Handle file upload
            $businessLogoPath = null;
            if ($request->hasFile('business_logo')) {
                $businessLogo = $request->file('business_logo');
                $businessLogoPath = $businessLogo->store('uploads/business_logos', 'public');
            }
            $business_id = Auth::guard('admins')->user()->business_id;
            
            $business_unit_id = 'BUSINESS_UNIT' . rand(100000, 999999);

            // Save data to database
            $businessUnit = BusinessUnit::create([
                'business_id' =>  $business_id,
                'business_unit_id' =>  $business_unit_id,
                'business_unit_name' => $request->business_unit_name,
                'business_logo' => $businessLogoPath,
                'mobile_number' => $request->mobile_number,
                'whatsapp_number' => $request->whatsapp_number,
                'user_name' => $request->user_name,
                'password' => Hash::make($request->password), // Encrypt password
                'locality' => $request->locality,
                'pincode' => $request->pincode,
                'city' => $request->city,
                'town' => $request->town,
                'state' => $request->state,
                'country' => $request->country,
                'full_address' => $request->full_address,
            ]);
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Business Unit created successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error creating business unit: ', ['error' => $e->getMessage()]);
            
            // Handle any unexpected errors
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
}
