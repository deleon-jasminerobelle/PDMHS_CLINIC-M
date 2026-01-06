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
            'student' => \App\Http\Middleware\StudentMiddleware::class,
            'admin.staff' => \App\Http\Middleware\AdminStaffMiddleware::class,
            'adviser' => \App\Http\Middleware\AdviserMiddleware::class,
            'clinic_staff' => \App\Http\Middleware\ClinicStaffMiddleware::class,
            'check.health.form' => \App\Http\Middleware\CheckHealthForm::class,
        ]);

        // Replace the default CSRF middleware with our custom one
        $middleware->replace(
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\VerifyCsrfToken::class
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
