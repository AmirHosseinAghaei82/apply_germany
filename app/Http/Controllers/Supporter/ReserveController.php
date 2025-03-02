<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supporter\AddTimeRequest;
use App\Services\Supporter\ReserveService;

class ReserveController extends Controller
{

    protected $reserveService;

    public function __construct(ReserveService $reserveService)
    {

        $this->reserveService = $reserveService;
        
    }
    

    public function addTime(AddTimeRequest $request)
    {

        return $this->reserveService->addTime($request);

    }


}
