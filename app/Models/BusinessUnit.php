<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class BusinessUnit extends Model
{
    // use HasFactory;
    use HasFactory, HasApiTokens;


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


    public function socialMediaLinks()
    {
        return $this->hasMany(BusinessUnitSocialMedia::class, 'business_unit_id', 'business_unit_id');
    }
    
    public function socialMedia()
{
    return $this->hasMany(BusinessUnitSocialMedia::class, 'business_unit_id', 'business_unit_id');
}

}
