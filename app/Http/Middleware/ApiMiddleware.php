<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    public function handle($request, Closure $next)
    {
        // if ($request->is('api/*')) {
        //     // this is an API request, so remove the web middleware
        //     $kernel = $this->app->make(Kernel::class);
        //     $kernel->removeMiddleware(\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class);
        //     $kernel->removeMiddleware(\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class);
        //     $kernel->removeMiddleware(\App\Http\Middleware\EncryptCookies::class);
        //     $kernel->removeMiddleware(\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class);
        //     $kernel->removeMiddleware(\Illuminate\Session\Middleware\StartSession::class);
        //     $kernel->removeMiddleware(\Illuminate\View\Middleware\ShareErrorsFromSession::class);
        // }

        return $next($request);
    }
}
