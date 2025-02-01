<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyMobile extends Model
{
    
    protected $fillable = [
        'mobile_number',
        'otp',
        'expired_at'
    ];

}
