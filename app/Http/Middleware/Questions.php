<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Http\Request;

class Questions
{

    public function handle(Request $request, Closure $next)
    {

        $user = request()->user();

        if($user->is_admin != true) {

            return ResponseService::responseMessage('دسترسی جهت ثبت سوالات را ندارید', false, 404);

        }

        return $next($request);

    }

}
