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

    public function addSupporter(array $data)
    {

        return Supporter::create($data);

    }

    public function supporters()
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

    public function supporter($id)
    {

        return Supporter::find($id);

    }

    public function user($supporterUserId)
    {

        return User::where('id', $supporterUserId)
        ->first();

    }

    public function supporterStatus($user, $status)
    {

        $user->update([
            'is_supporter' => $status
        ]);


    }

    public function supporterMessage($message, $supporter)
    {

        $supporter->update([
            'message' => $message
        ]);

    }

    // public function supporters()
    // {

    //     return User::where('is_supporter', true)
    //     ->get();

    // }

    // public function supporter($id)
    // {

    //     return User::where('id', $id)
    //     ->where('is_supporter', true)
    //     ->first();

    // }

}