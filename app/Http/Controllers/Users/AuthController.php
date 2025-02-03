<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Requests\Users\SendOtpRequest;
use App\Http\Requests\Users\VerifyMobileRequest;
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

    public function verifyMobile(VerifyMobileRequest $request)
    {

        return $this->authService->verifyMobile($request);

    }

    public function register(RegisterRequest $request)
    {

        return $this->authService->register($request);

    }



}
