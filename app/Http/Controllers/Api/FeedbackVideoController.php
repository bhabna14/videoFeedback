<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackVideo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FeedbackVideoController extends Controller
{
    public function saveFeedbackVideo(Request $request)
    {
        try {
            // Check if a video file is uploaded
            if ($request->hasFile('feedback_video')) {
                $video = $request->file('feedback_video');
                $videoPath = $video->store('uploads/feedback_videos', 'public');
    
                // Get the full URL for the uploaded video
                $videoUrl = asset('storage/' . $videoPath);
    
                // Retrieve the authenticated business unit
                $business_unit_id = Auth::guard('sanctum')->user()->business_unit_id;
    
                // Get the current date and time
                $currentDate = Carbon::now('Asia/Kolkata')->toDateString(); // Format: 'YYYY-MM-DD'
                $currentTime = Carbon::now('Asia/Kolkata')->toTimeString(); // Format: 'HH:MM:SS'
    
                // Save feedback video
                $feedbackVideo = FeedbackVideo::create([
                    'business_unit_id' => $business_unit_id,
                    'feedback_video' => $videoUrl,
                    'date' => $currentDate,
                    'time' => $currentTime,
                ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Feedback video uploaded successfully!',
                    'data' => $feedbackVideo,
                ], 200);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'No video file was uploaded.',
            ], 400);
    
        } catch (\Exception $e) {
            \Log::error('Feedback video upload error: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the feedback video.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
}
