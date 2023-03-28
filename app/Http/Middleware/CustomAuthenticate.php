<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
//use Illuminate\Support\Facades\Auth;


class CustomAuthenticate
{

    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::guard('api')->check()) {
            // If the user is authenticated, allow them to access the protected route.
            return $next($request);
        }

        // If the user is not authenticated, return a JSON response with an error message.
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}
