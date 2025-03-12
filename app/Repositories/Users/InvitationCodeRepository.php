<?php 

namespace App\Repositories\Users;

use App\Models\InvitationCode;
use Illuminate\Support\Facades\DB;

class InvitationCodeRepository
{

    public function receiverUser($request)
    {

        return DB::table('users')
        ->select(
            'id',
            'is_register'
        )
        ->where('mobile_number', $request->mobile_number)
        ->first();

    }

    public function addCode($operator, $data)
    {

        return InvitationCode::updateOrCreate($operator, $data);

    }

}