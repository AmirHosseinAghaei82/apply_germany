<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\SendOtpRequest;
use App\Services\AuthService;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        
        $this->authService = $authService;

    }
    
    public function sendOtp(SendOtpRequest $request)
    {

        return $this->authService->sendOtp($request);

    } 

}
