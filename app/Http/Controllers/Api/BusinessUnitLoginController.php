<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessUnit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BusinessUnitLoginController extends Controller
{
    public function loginBusinessUnit(Request $request)
    {

        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 400);
            }

            // Check if the business user exists
            $business = BusinessUnit::where('user_name', $request->user_name)->first();

            if (!$business || !Hash::check($request->password, $business->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials. Please try again.',
                ], 401);
            }

            // Generate the API token for the business unit
            $token = $business->createToken('BusinessUnitLogin')->plainTextToken;

            // Return response with token and order ID
            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'data' => [
                    'order_id' => $business->business_id, // Assuming 'business_id' is used as order_id
                    'token' => $token, // Bearer token for subsequent requests
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while logging in.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
