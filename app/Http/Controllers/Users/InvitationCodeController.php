<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddCodeRequest;
use App\Services\Users\InvitationCodeService;
use Illuminate\Http\Request;

class InvitationCodeController extends Controller
{

    protected $service;

    public function __construct(InvitationCodeService $invitationCodeService)
    {

        $this->service = $invitationCodeService;
        
    }
    
    public function addCode(AddCodeRequest $request)
    {

        return $this->service->addCode($request);

    }


}
