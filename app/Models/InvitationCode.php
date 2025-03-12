<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationCode extends Model
{
    
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'invitation_code',
        'code_used'
    ];

}
