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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.health.form' => \App\Http\Middleware\CheckHealthForm::class,
            'student' => \App\Http\Middleware\StudentMiddleware::class,
            'admin.staff' => \App\Http\Middleware\AdminStaffMiddleware::class,
            'adviser' => \App\Http\Middleware\AdviserMiddleware::class,
            'clinic.staff' => \App\Http\Middleware\ClinicStaffMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
