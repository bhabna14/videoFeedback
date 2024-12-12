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
        $request->validate([
            'feedback_video' => 'required|mimes:mp4,mov,avi,wmv',
        ]);

        if ($request->hasFile('feedback_video')) {
            $video = $request->file('feedback_video');
            // Store the file in the 'public' disk, which will save it under 'storage/app/public'
            $videoPath = $video->store('uploads/feedback_videos', 'public');
            
            // Save the file path without the 'storage/' part in the database
            $videoPathWithoutStorage = str_replace('public/', '', $videoPath);

            // Create the feedback video record
            $feedbackVideo = FeedbackVideo::create([
                'feedback_video' => $videoPathWithoutStorage, // Save without 'storage/'
            ]);

            // Get the full URL for the uploaded video, including 'storage/'
            $videoUrl = asset('storage/' . $videoPath);

            return response()->json([
                'success' => true,
                'message' => 'Feedback video uploaded successfully!',
                'data' => [
                    'feedback_video' => $videoUrl, // Include the full URL in the response
                    'video_path' => $videoPathWithoutStorage, // Store the path without 'storage/'
                ],
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
