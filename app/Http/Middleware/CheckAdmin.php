<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{

    public function handle(Request $request, Closure $next)
    {

        $user = request()->user();

        if($user->is_admin == false) {

            return ResponseService::responseMessage('دسترسی به این بخش را ندارید', false, 403);

        }

        return $next($request);

    }

}
