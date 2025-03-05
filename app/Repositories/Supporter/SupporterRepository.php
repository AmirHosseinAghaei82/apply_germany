<?php 

namespace App\Repositories\Supporter;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SupporterRepository
{

    public function checkResumeExist($id)
    {

        return Resume::where('user_id', $id)
        ->first();

    }

    public function sendresume(array $data)
    {

        return Resume::create($data);

    }

    public function resumes()
    {

        return DB::table('resumes')
        ->select(
            'resumes.*',
            'users.first_name',
            'users.last_name'
        )
        ->join('users', 'users.id', '=', 'resumes.user_id')
        ->get();

    }

    public function resume($id)
    {

        return DB::table('resumes')
        ->select(
            'resumes.*',
            'users.first_name',
            'users.last_name'
        )
        ->where('resumes.id', '=', $id)
        ->join('users', 'resumes.user_id', '=', 'users.id')
        ->first();

    }

    public function user($supporterUserId)
    {

        return User::where('id', $supporterUserId)
        ->first();

    }

    public function resumeStatus($user, $status)
    {

        $user->update([
            'is_supporter' => $status
        ]);


    }

    public function resumeMessage($message, $id)
    {

        DB::table('resumes')
        ->where('id', $id)
        ->update(['message' => $message]);

    }

    public function adminSupporters()
    {

        return User::where('is_supporter', true)
        ->get();

    }

    public function adminSupporter($id)
    {

        return User::where('id', $id)
        ->where('is_supporter', true)
        ->first();

    }

    public function supporters()
    {

        return DB::table('users')
        ->select(
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.image',
            'users.ability'
        )
        ->where('is_supporter', true)
        ->get();

    }

    public function supporter($id)
    {

        return DB::table('users')
        ->select(
            'supporters.supporter_id',
            'supporters.id',
            'users.first_name',
            'users.last_name',
            'users.image',
            'users.ability',
            'supporters.start_time',
            'supporters.end_time',
        )
        ->where('users.id', $id)
        ->where('is_supporter', true)
        ->join('supporters', 'users.id', "=", 'supporters.supporter_id')
        ->get();

    }

}