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
                $videoPath = $video->store('uploads/feedback_videos', 'public');

                $feedbackVideo = FeedbackVideo::create([
                    'feedback_video' => $videoPath,
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
