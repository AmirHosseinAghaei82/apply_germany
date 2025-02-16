<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supporter extends Model
{
    
    protected $fillable = [
        'user_id',
        'resume',
        'description',
        'message'
    ];

}
