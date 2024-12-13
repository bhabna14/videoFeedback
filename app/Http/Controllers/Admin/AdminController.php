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

    // public function showDashboard(Request $request)
    // {
    //     // $business_id = Auth::guard('admins')->user()->business_id;
        
    //     // $query = FeedbackVideo::where('status', 'active')
    //     //     ->whereHas('businessUnit', function ($query) use ($business_id) {
    //     //         $query->where('business_id', $business_id); // Filter feedback videos based on business_id
    //     //     })
    //     //     ->with('businessUnit');  // Eager loading the businessUnit relationship
    //     $query = FeedbackVideo::where('status', 'active')->get();
    //     // if ($request->filled('business_unit_id') && $request->business_unit_id !== 'All') {
    //     //     $query->where('business_unit_id', $request->business_unit_id);
    //     // }
    
    //     if ($request->filled('from_date')) {
    //         $fromDate = Carbon::parse($request->from_date)->startOfDay();
    //         $query->where('date', '>=', $fromDate);
    //     }
    
    //     if ($request->filled('to_date')) {
    //         $toDate = Carbon::parse($request->to_date)->endOfDay();
    //         $query->where('date', '<=', $toDate);
    //     }

    //     $feedback_video = $query->get(['id', 'feedback_video', 'date', 'time']); // Select necessary columns
    
    //     $businessName = Auth::guard('admins')->user()->business_name ?? 'User';
    
    //     $businessUnits = BusinessUnit::where('business_id', $business_id)->get();
    
    //     return view('dash-board', compact('businessUnits','businessName'.'feedback_video'));
    // }

    public function showDashboard(Request $request)
{
    // Initial query to fetch active feedback videos
    $query = FeedbackVideo::where('status', 'active');

    // Apply filters if provided in the request
    if ($request->filled('from_date')) {
        $fromDate = Carbon::parse($request->from_date)->startOfDay();
        $query->where('date', '>=', $fromDate);
    }

    if ($request->filled('to_date')) {
        $toDate = Carbon::parse($request->to_date)->endOfDay();
        $query->where('date', '<=', $toDate);
    }

    // Fetch the filtered data
    $feedback_video = $query->get(['id', 'feedback_video', 'date', 'time']); // Select necessary columns

    // Fetch all business units (no filtering by business_id)
    $businessUnits = BusinessUnit::all();
    $businessName = Auth::guard('admins')->user()->business_name ?? 'User';
    
    // Pass data to the view
    return view('dash-board', compact('businessUnits', 'businessName','feedback_video'));
}


    public function disableVideoFeedback($id)
{
    $feedbackVideo = FeedbackVideo::findOrFail($id);
    
    // Mark as disabled
    $feedbackVideo->status = 'disabled';
    $feedbackVideo->save();

    // Optionally, return a response or redirect
    return redirect()->back()->with('message', 'Video disabled successfully');

}

public function deleteVideoFeedback($id)
{
    try {
        // Find the video feedback by ID
        $feedbackVideo = FeedbackVideo::findOrFail($id);

        // Define the path to the video file
        $videoPath = public_path($feedbackVideo->feedback_video);

        // Check if the file exists before attempting to delete
        if (file_exists($videoPath)) {
            if (unlink($videoPath)) { // Delete the file
                \Log::info("Video file deleted: " . $videoPath);
            } else {
                \Log::warning("Failed to delete video file: " . $videoPath);
            }
        } else {
            \Log::warning("Video file does not exist: " . $videoPath);
        }

        // Permanently delete the record from the database
        $feedbackVideo->delete();

        // Return success response
        return redirect()->back()->with('message', 'Video deleted successfully');
    } catch (\Exception $e) {
        \Log::error("Error deleting video feedback: " . $e->getMessage());
        return redirect()->back()->with('error', 'Error occurred while deleting the video');
    }
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
