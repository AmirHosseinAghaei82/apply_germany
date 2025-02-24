<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\VerifyEmail;
use App\Models\VerifyMobile;
use Carbon\Carbon;

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

    public function sendEmail(array $operator, array $data)
    {

        return VerifyEmail::updateOrCreate($operator, $data);

    }

    public function checkEmailtime($request)
    {

        return VerifyEmail::where('email', $request->email)
        ->first();
        
    }

    public function checkEmail($request)
    {

        return VerifyEmail::where('email', $request->email)
        ->where('email_code', $request->email_code)
        ->first();

    }

    public function verifyEmail($user, $checkEmail)
    {

        return $user->update([
            'email'             => $checkEmail->email,
            'email_verified_at' => Carbon::now()
        ]);

    }

    public function register(array $operator, array $data)
    {

        return User::updateOrCreate($operator, $data);

    }

    public function editDashboard($user, $updateData)
    {

        return $user->update($updateData);

    }

    

}