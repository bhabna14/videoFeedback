<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackVideo;
use Illuminate\Support\Facades\Storage;

class FeedbackVideoController extends Controller
{
    public function saveFeedbackVideo(Request $request)
    {
        try {
           
    
            if ($request->hasFile('feedback_video')) {
                $video = $request->file('feedback_video');
                $videoPath = $video->store('uploads/feedback_videos', 'public');
    
                // Get the full URL for the uploaded video
                $videoUrl = asset('storage/' . $videoPath); // This assumes you have a symbolic link to public/storage
    
                $feedbackVideo = FeedbackVideo::create([
                    'feedback_video' => $videoUrl,
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
            ], 500);
        }
    }
    
}
