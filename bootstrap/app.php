<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'level' => \App\Http\Middleware\CheckLevel::class,
            'app.auth' => \App\Http\Middleware\CheckLogin::class,
            'app.super' => \App\Http\Middleware\CheckSuperAdmin::class,
            'app.withOutObrik' => \App\Http\Middleware\LevelWithOutObrik::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
