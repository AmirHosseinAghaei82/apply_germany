<?php

use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Middleware\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function() {
    
    Route::post('/send/otp', 'sendOtp');
    
    Route::post('/verify/mobile', 'verifyMobile');
    
    Route::post('/register', 'register')->middleware('auth:sanctum');
    
    Route::post('/login', 'login');

    Route::get('/logout', 'logOut')->middleware('auth:sanctum');

});

Route::controller(QuestionsController::class)->group(function() {

    Route::post('/add/question', 'addQuestion')->middleware('auth:sanctum', Questions::class);

    Route::get('/questions', 'questions');

    Route::delete('/delete/question/{id}', 'deleteQuestion')->middleware('auth:sanctum', Questions::class);

});