<?php 

namespace App\Repositories\Supporter;

use App\Models\Supporter;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SupporterRepository
{

    public function checkResumeExist($id)
    {

        return Supporter::where('user_id', $id)
        ->first();

    }

    public function sendresume(array $data)
    {

        return Supporter::create($data);

    }

    public function resumes()
    {

        return DB::table('supporters')
        ->select(
            'supporters.*',
            'users.first_name',
            'users.last_name'
        )
        ->join('users', 'users.id', '=', 'supporters.user_id')
        ->get();

    }

    public function resume($id)
    {

        return DB::table('supporters')
        ->select(
            'supporters.*',
            'users.first_name',
            'users.last_name'
        )
        ->where('supporters.id', '=', $id)
        ->join('users', 'supporters.user_id', '=', 'users.id')
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

        DB::table('supporters')
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
            'users.first_name',
            'users.last_name',
            'users.image',
            'users.ability'
        )
        ->where('is_supporter', true)
        ->get();

    }

}