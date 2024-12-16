<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackFollowUp extends Model
{
    use HasFactory;

    protected $table = 'feedback_follow_up';

    protected $fillable = [
        'feedback_video_id',
        'comments',
        'date',
        'time',
    ];

    public function feedbackVideo()
    {
        return $this->belongsTo(FeedbackVideo::class, 'feedback_video_id', 'id');
    }
}
