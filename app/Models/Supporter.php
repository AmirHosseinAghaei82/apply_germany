<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supporter extends Model
{
    
    protected $fillable = [
        'supporter_id',
        'start_time',
        'end_time',
        'is_reserved'
    ];

}
