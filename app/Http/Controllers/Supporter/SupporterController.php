<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supporter\AddSupporterRequest;
use App\Http\Requests\Supporter\SupporterStatusRequest;
use App\Services\Supporter\SupporterService;
use Illuminate\Http\Request;

class SupporterController extends Controller
{

    protected $supporterService;

    public function __construct(SupporterService $supporterService)
    {

        $this->supporterService = $supporterService;
        
    }
    
    public function addSupporter(AddSupporterRequest $request)
    {

        return $this->supporterService->addSupporter($request);

    }

    public function supporters()
    {

        return $this->supporterService->supporters();

    }

    public function supporter($id)
    {

        return $this->supporterService->supporter($id);

    }

    public function editSupporter(SupporterStatusRequest $request, $id)
    {

        return $this->supporterService->editSupporter($request, $id);

    }

    // public function supporters()
    // {

    //     return $this->supporterService->supporters();

    // }

    // public function supporter($id)
    // {

    //     return $this->supporterService->supporter($id);

    // }

}
