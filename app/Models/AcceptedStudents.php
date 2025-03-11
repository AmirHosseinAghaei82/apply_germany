<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcceptedStudents extends Model
{

    protected $fillable = [
        'first_name',
        'last_name',
        'field',
        'university',
        'image'
    ];
    
}
