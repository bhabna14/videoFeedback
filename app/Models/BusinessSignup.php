<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSignup extends Model
{
    use HasFactory;

    protected $table = 'business_signup';

    protected $fillable = [
        'business_id',
        'business_name',
        'mobile_number',
        'user_name',
        'email',
        'password',
        'role',
    ];
}
