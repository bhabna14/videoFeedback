<?php

namespace App\Http\Controllers\Admin;

use App\Models\FeedbackVideo;
use App\Models\BusinessUnit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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

    public function showDashboard(Request $request)
    {
        $business_id = Auth::guard('admins')->user()->business_id;
        
        $query = FeedbackVideo::where('status', 'active')
            ->whereHas('businessUnit', function ($query) use ($business_id) {
                $query->where('business_id', $business_id); // Filter feedback videos based on business_id
            })
            ->with('businessUnit');  // Eager loading the businessUnit relationship
    
        if ($request->filled('business_unit_id') && $request->business_unit_id !== 'All') {
            $query->where('business_unit_id', $request->business_unit_id);
        }
    
        if ($request->filled('from_date')) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $query->where('date', '>=', $fromDate);
        }
    
        if ($request->filled('to_date')) {
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $query->where('date', '<=', $toDate);
        }

        $feedback_video = $query->get(['id', 'business_unit_id', 'feedback_video', 'date', 'time']); // Select necessary columns
    
        $businessName = Auth::guard('admins')->user()->business_name ?? 'User';
    
        $businessUnits = BusinessUnit::where('business_id', $business_id)->get();
    
        return view('dash-board', compact('businessName', 'feedback_video', 'businessUnits'));
    }

    public function disableVideoFeedback($id)
{
    $feedbackVideo = FeedbackVideo::findOrFail($id);
    
    // Mark as disabled
    $feedbackVideo->status = 'disabled';
    $feedbackVideo->save();

    // Optionally, return a response or redirect
    return response()->json(['message' => 'Video disabled successfully']);
}

public function deleteVideoFeedback($id)
{
    $feedbackVideo = FeedbackVideo::findOrFail($id);

    // Delete video file from storage
    $videoPath = public_path($feedbackVideo->feedback_video);
    if (file_exists($videoPath)) {
        unlink($videoPath); // Delete the file
    }

    // Permanently delete the record from the database
    $feedbackVideo->delete();

    // Optionally, return a response or redirect
    return response()->json(['message' => 'Video deleted successfully']);
}

public function saveComment(Request $request, $videoId)
{
    // Validate the comment input
    $request->validate([
        'comments' => 'required|string|max:255', // You can change the validation as per your requirements
    ]);

    // Find the feedback video by ID
    $feedbackVideo = FeedbackVideo::find($videoId);

    if ($feedbackVideo) {
        // Update the comment for the selected video
        $feedbackVideo->comments = $request->comments;
        $feedbackVideo->save();

        // Optionally, return a success response or redirect back with success message
        return redirect()->back()->with('success', 'Comment saved successfully!');
    }

    // If video not found
    return redirect()->back()->with('error', 'Feedback video not found.');
}

public function saveRating(Request $request, $videoId)
{
    $video = FeedbackVideo::findOrFail($videoId);
    $video->rating = $request->rating; // Save the rating (like or dislike)
    $video->save();

    // Return back with a success message
    return redirect()->back()->with('success', 'Rating saved successfully!');
}

    

}
