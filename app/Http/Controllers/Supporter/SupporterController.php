<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supporter\AddSupporterRequest;
use App\Http\Requests\Supporter\EditResumeRequest;
use App\Http\Requests\Supporter\SendResumeRequest;
use App\Http\Requests\Supporter\SendResumeSupporter;
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
    
    public function sendResume(SendResumeRequest $request)
    {

        return $this->supporterService->sendResume($request);

    }

    public function resumes()
    {

        return $this->supporterService->resumes();

    }

    public function resume($id)
    {

        return $this->supporterService->resume($id);

    }

    public function editResume(EditResumeRequest $request, $id)
    {

        return $this->supporterService->editResume($request, $id);

    }

    public function adminSupporters()
    {

        return $this->supporterService->adminSupporters();

    }

    public function adminSupporter($id)
    {

        return $this->supporterService->adminSupporter($id);

    }

    public function supporters()
    {

        return $this->supporterService->supporters();

    }

}
