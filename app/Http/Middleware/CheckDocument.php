<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDocument
{

    public function handle(Request $request, Closure $next): Response
    {

        $user = request()->user();

        if(($user->is_admin == false) && ($user->is_supporter == false)) {

            return ResponseService::responseMessage('دسترسی به این بخش را ندارید', false, 403);

        }

        return $next($request);

    }
}
