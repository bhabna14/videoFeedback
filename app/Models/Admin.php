<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins'; // Replace 'admins' with your admin table name

    protected $fillable = [
        'business_id',
        'business_name',
        'mobile_number',
        'user_name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];
}

