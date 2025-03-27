<?php

use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\ForcePasswordChange;
use App\Http\Middleware\CheckUserAccess;
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
        $middleware->alias([
            'isAdmin' => CheckUserAccess::class,
            'isActive' => CheckUserStatus::class,
            'forcePassChange' => ForcePasswordChange::class,
        ]);
    
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
