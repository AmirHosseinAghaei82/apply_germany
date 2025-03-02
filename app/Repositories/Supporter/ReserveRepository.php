<?php

namespace App\Repositories\Supporter;

use App\Models\Supporter;

class ReserveRepository
{

    public function addTime(array $data)
    {

        return Supporter::create($data);

    }



}