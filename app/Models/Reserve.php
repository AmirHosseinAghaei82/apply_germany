<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    
    protected $fillable = [
        'supporter_id',
        'user_id',
        'start_time',
        'end_time',
        'reserved_time',
        'message'
    ];

}
