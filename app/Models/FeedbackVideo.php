<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackVideo extends Model
{
    use HasFactory;

    protected $table = 'business_feedback';

    protected $fillable = [
        // 'business_id',
        // 'business_unit_id',
        'feedback_video',
    ];
}
