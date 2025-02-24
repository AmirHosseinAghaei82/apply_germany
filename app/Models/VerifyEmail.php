<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyEmail extends Model
{

    protected $fillable =[
        'email',
        'email_code',
        'expired_at'
    ];

}
