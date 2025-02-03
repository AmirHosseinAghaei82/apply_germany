<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\VerifyMobile;

class AuthRepository 
{

    public function sendOtp(array $operator, array $data) :VerifyMobile
    {
      
        return VerifyMobile::updateOrCreate($operator, $data);

    }


    public function verifyMobile(array $data)
    {

        return User::create($data);

    }

    public function register(array $operator, array $data)
    {

        return User::updateOrCreate($operator, $data);

    }

    

}