<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supporter\AddTimeRequest;
use App\Http\Requests\Supporter\EditTimeRequest;
use App\Services\ResponseService;
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

    public function times()
    {

        return $this->reserveService->times();

    }

    public function editTime(EditTimeRequest $request, $id)
    {

        return $this->reserveService->editTime($request, $id);

    }

    public function deleteTime($id)
    {

        return $this->reserveService->deleteTime($id);

    }


}
