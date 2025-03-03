<?php

namespace App\Repositories\Supporter;

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

    public function time($user, $id)
    {

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



}