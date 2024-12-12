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

    public function manageBusinessUnit()
    {
        // Fetch all business units from the database
        $businessUnits = BusinessUnit::where('status','active')->get();

        // Return the view and pass the business units to it
        return view('admin/manage-business-unit', compact('businessUnits'));
    }
    

public function deleteBusinessUnit(Request $request, $id)
{
    try {
        $businessUnit = BusinessUnit::findOrFail($id);
        $businessUnit->status = 'deleted';
        $businessUnit->save();

        return redirect()->back()->with('success', 'Business unit marked as deleted successfully!');
    } catch (\Exception $e) {
        \Log::error('Error deleting business unit: ' . $e->getMessage());

        return redirect()->back()->with('error', 'An error occurred while deleting the business unit.');
    }
}

public function editBusinessUnit($id)
{
    $businessUnit = BusinessUnit::findOrFail($id); // Fetch the specific business unit

    return view('admin.edit-business-unit', compact('businessUnit'));
}

public function updateBusinessUnit(Request $request, $id)
{
    $request->validate([
        'business_unit_name' => 'required|string|max:255',
        'business_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        'mobile_number' => 'nullable|numeric',
        'whatsapp_number' => 'nullable|numeric',
        'user_name' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:255',
        'locality' => 'nullable|string|max:255',
        'pincode' => 'nullable|numeric',
        'city' => 'nullable|string|max:255',
        'town' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'full_address' => 'nullable|string',
    ]);

    try {
        $businessUnit = BusinessUnit::findOrFail($id);
        $businessUnit->business_unit_name = $request->business_unit_name;

        if ($request->hasFile('business_logo')) {
            $businessLogo = $request->file('business_logo');
            $businessLogoPath = $businessLogo->store('uploads/business_logos', 'public');
            $businessUnit->business_logo = $businessLogoPath;
        }
        

        $businessUnit->mobile_number = $request->mobile_number;
        $businessUnit->whatsapp_number = $request->whatsapp_number;
        $businessUnit->user_name = $request->user_name;

        if ($request->filled('password')) {
            $businessUnit->password = bcrypt($request->password); // Remember to hash the password before saving
        }
        
        $businessUnit->locality = $request->locality;
        $businessUnit->pincode = $request->pincode;
        $businessUnit->city = $request->city;
        $businessUnit->town = $request->town;
        $businessUnit->state = $request->state;
        $businessUnit->country = $request->country;
        $businessUnit->full_address = $request->full_address;

        $businessUnit->save();

        return redirect()->route('manageBusinessUnit')->with('success', 'Business Unit updated successfully!');
    } catch (\Exception $e) {
        \Log::error('Error updating business unit: ' . $e->getMessage());
        return back()->withErrors(['danger' => 'An error occurred while updating the business unit.']);
    }
}

}
