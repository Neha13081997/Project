<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AuthGatesMiddleware::class,
            \App\Http\Middleware\RedirectIfInactiveMiddleware::class,
        ]);

        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AuthGatesMiddleware::class,
            \App\Http\Middleware\CheckUserStatusMiddleware::class,
        ]);

        $middleware->alias([
            'preventBackHistory' =>\App\Http\Middleware\PreventBackHistoryMiddleware::class,
            'AuthGates' =>\App\Http\Middleware\AuthGatesMiddleware::class,
            'checkUserStatus' => \App\Http\Middleware\CheckUserStatusMiddleware::class,
            'userinactive' => \App\Http\Middleware\RedirectIfInactiveMiddleware::class,
            'check.device' => \App\Http\Middleware\LogoutUserFromOtherDeviceMiddleware::class,
            'role' => \App\Http\Middleware\CheckRoleMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticatedMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

