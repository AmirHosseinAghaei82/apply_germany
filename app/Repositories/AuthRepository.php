<?php 

namespace App\Repositories;

use App\Models\VerifyMobile;

class AuthRepository 
{

    public function updateOrCreate(array $operator, array $data) :VerifyMobile
    {
      
        return VerifyMobile::updateOrCreate($operator, $data);

    }

}