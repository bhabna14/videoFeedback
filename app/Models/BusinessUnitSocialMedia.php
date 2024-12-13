<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnitSocialMedia extends Model
{
    use HasFactory;

    protected $table = 'business_unit_social_media';

    protected $fillable = [
        'business_id',
        'business_unit_id',
        'social_media_name',
        'social_media_link',
    ];

}
