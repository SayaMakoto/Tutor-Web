<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {

        $middleware->validateCsrfTokens(except: [
            '*',
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        });

        $middleware->redirectUsersTo(function ($request) {
            if ($request->is('admin/login') || $request->is('admin/login/*')) {
                return route('admin.home');
            }
            return route('student.home');
        });

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'not.tutor' => \App\Http\Middleware\EnsureNotTutor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();