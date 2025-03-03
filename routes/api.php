<?php

use App\Http\Controllers\Admin\AcceptedStudentsController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Supporter\ReserveController;
use App\Http\Controllers\Supporter\SupporterController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\DocumentsController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckDocument;
use App\Http\Middleware\CheckSupporter;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function() {
    
    Route::post('/send/otp', 'sendOtp');

    Route::post('/verify/mobile', 'verifyMobile');
    
    Route::post('/send/email', 'sendEmail')->middleware('auth:sanctum');

    Route::post('/verify/email', 'verifyEmail')->middleware('auth:sanctum');

    Route::post('/register', 'register')->middleware('auth:sanctum');
    
    Route::post('/login', 'login');

    Route::get('/logout', 'logOut')->middleware('auth:sanctum');

    Route::get('dashboard', 'dashboard')->middleware('auth:sanctum');

    Route::post('edit/dashboard', 'editDashboard')->middleware('auth:sanctum');

});

Route::controller(QuestionsController::class)->group(function() {
    
    Route::get('/questions', 'questions');

    Route::get('/question/{id}', 'question');

    Route::post('/add/question', 'addQuestion')->middleware('auth:sanctum', CheckAdmin::class);

    Route::delete('/delete/question/{id}', 'deleteQuestion')->middleware('auth:sanctum', CheckAdmin::class);

    Route::post('/edit/question/{id}', 'editQuestion')->middleware('auth:sanctum', CheckAdmin::class);

});

Route::controller(BlogsController::class)->group(function() {

    Route::get('/blogs', 'blogs');

    Route::get('/blog/{alias_title}', 'blog');

    Route::post('/add/blog', 'addBlog')->middleware('auth:sanctum', CheckAdmin::class);

    Route::post('/edit/blog/{id}', 'editBlog')->middleware('auth:sanctum', CheckAdmin::class);

    Route::delete('/delete/blog/{id}', 'deleteBlog')->middleware('auth:sanctum', CheckAdmin::class);

});

Route::controller(AcceptedStudentsController::class)->group(function() {

    Route::get('/accepted/students', 'acceptedStudents');

    Route::get('/accepted/student/{id}', 'acceptedStudent');

    Route::post('add/accepted/student', 'addAcceptedStudent')->middleware('auth:sanctum', CheckAdmin::class);

    Route::post('/edit/accepted/student/{id}', 'editAcceptedStudent')->middleware('auth:sanctum', CheckAdmin::class);

    Route::delete('/delete/accepted/student/{id}', 'deleteAcceptedStudent')->middleware('auth:sanctum', CheckAdmin::class);

});

Route::controller(SupporterController::class)->group(function() {

    Route::post('/send/resume', 'sendResume')->middleware('auth:sanctum');

    Route::get('/resumes', 'resumes')->middleware('auth:sanctum', CheckAdmin::class);

    Route::get('/resume/{id}', 'resume')->middleware('auth:sanctum', CheckAdmin::class);

    Route::post('/edit/resume/{id}', 'editResume')->middleware('auth:sanctum', CheckAdmin::class);

    Route::get('/admin/supporters', 'adminSupporters')->middleware('auth:sanctum', CheckAdmin::class);

    Route::get('/admin/supporter/{id}', 'adminSupporter')->middleware('auth:sanctum', CheckAdmin::class);

    Route::get('/supporters', 'supporters');

});

Route::middleware('auth:sanctum', CheckSupporter::class)->controller(ReserveController::class)->group(function() {

    Route::post('/add/time', 'addTime');

    Route::get('/times', 'times');

    Route::get('/time/{id}', 'time');

    Route::post('/edit/time/{id}', 'editTime');

    Route::delete('/delete/time/{id}', 'deleteTime');


});

Route::controller(DocumentsController::class)->group(function() {

    Route::post('/add/document', 'addDocument')->middleware('auth:sanctum');

    Route::get('/documents', 'documents')->middleware('auth:sanctum', CheckDocument::class);

    Route::get('/document/{id}', 'document')->middleware('auth:sanctum', CheckDocument::class);

});



