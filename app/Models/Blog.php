<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    
    protected $fillable = [
        'title',
        'alias_title',
        'description',
        'content',
        'image',
        'alt',
    ];

}
