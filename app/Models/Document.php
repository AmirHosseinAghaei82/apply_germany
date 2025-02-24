<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    
    protected $fillable = [
        'user_id',
        'high_school',
        'high_school_description',
        'bachelor',
        'bachelor_description',
        'language',
        'language_description',
        'passport',
        'passport_description',
        'image',
        'image_description',
        'exam_success',
        'exam_success_description',
        'work',
        'work_description',
        'other',
        'other_description'
    ];  

}
