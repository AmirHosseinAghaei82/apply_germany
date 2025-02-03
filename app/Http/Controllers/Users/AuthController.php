<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Requests\Users\SendOtpRequest;
use App\Http\Requests\Users\VerifyMobileRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

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

    public function login(LoginRequest $request)
    {

        return $this->authService->login($request);

    }

    public function logOut()
    {

        return $this->authService->logOut();

    }



}
