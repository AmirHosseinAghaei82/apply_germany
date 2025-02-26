<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supporter extends Model
{
    
    protected $fillable = [
        'month',
        'day',
        'start_time',
        'end_time',
        'is_reserved'
    ];

}
