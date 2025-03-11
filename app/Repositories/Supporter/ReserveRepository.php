<?php

namespace App\Repositories\Supporter;

use App\Models\Reserve;
use App\Models\Supporter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReserveRepository
{

    public function addTime(array $data)
    {

        return Supporter::create($data);

    }

    public function times($user)
    {

        return DB::table('supporters')
        ->select()
        ->where('supporter_id', $user->id)
        ->get();
 
    }

    public function time($user, $id = null)
    {

        if($id == null || $user == null) {
            
            return Supporter::where('supporter_id', $user->supporter_id)
            ->where('id', $user->id)
            ->first();
     
        }

        return Supporter::where('supporter_id', $user->id)
        ->where('id', $id)
        ->first();



    }

    public function updateTime($updateTime, $time)
    {
        return $time->update($updateTime);

    }

    public function deleteTime($time)
    {

        return $time->delete();

    }

    public function reserveTime(array $data) 
    {

        return Reserve::create($data);

    }

    public function isReserved($time)
    {

        $time->update([
            'is_reserved' => true
        ]);

    }

    public function adminReservedTimes()
    {

        return DB::table('reserves')
        ->select(
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'user.mobile_number as user_mobile_number',
            'supporter.first_name as supporter_first_name',
            'supporter.last_name as supporter_last_name',
            'supporter.mobile_number as supporter_mobile_number',
            'reserves.message as reserve_message'
        )
        ->leftJoin('users as user', 'reserves.user_id', '=', 'user.id')
        ->leftJoin('users as supporter', 'reserves.supporter_id', '=', 'supporter.id')
        ->get();

    }

    public function supporterReservedTimes($user)
    {

        return DB::table('reserves')
        ->select(
            'users.first_name',
            'users.last_name',
            'users.mobile_number',
            'reserves.start_time',
            'reserves.end_time',
            'reserves.message'
        )
        ->where('reserves.supporter_id', $user->id)
        ->join('users', 'users.id', '=', 'reserves.user_id')
        ->get();

    }

    public function reservedTimes($user)
    {

        return DB::table('reserves')
        ->select(
            'reserves.supporter_id'
        )
        ->where('users.id', $user->id)
        ->join('users', 'users.id', '=', 'reserves.user_id')
        ->get()
        ->map(function($query) {

            $data = $query->supporter_id;

            return $data;

        });

    }

    public function supporterInfo($reservedTimes)
    {

        return DB::table('users')
        ->select(
            'first_name',
            'last_name',
            'image'
        )
        ->whereIn('id', $reservedTimes)
        ->get();

    }

}