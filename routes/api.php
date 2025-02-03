<?php

use App\Http\Controllers\Users\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function() {
    
    Route::post('/send/otp', 'sendOtp');
    
    Route::post('/verify/mobile', 'verifyMobile');
    
    Route::post('/register', 'register')->middleware('auth:sanctum');
    
    Route::post('/login', 'login');
    


    

});