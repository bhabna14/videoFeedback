<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;

    protected $table = 'business_unit';

    protected $fillable = [
        'business_id',
        'business_unit_id',
        'business_unit_name',
        'business_logo',
        'mobile_number',
        'whatsapp_number',
        'user_name',
        'password',
        'locality',
        'pincode',
        'city',
        'town',
        'state',
        'country',
        'full_address',
    ];
    
}
