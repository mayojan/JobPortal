<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // مدیریت خطای عدم احراز هویت (AuthenticationException - 401) طبق بند 4.1 استاد
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Authentication required',
                    'errors'  => new \stdClass(), // ابجکت خالی استاندارد
                ], 401);
            }
        });

        // مدیریت خطای عدم سطح دسترسی (AuthorizationException - 403) طبق بند 4.1 استاد
        $exceptions->render(function (
            \Illuminate\Auth\Access\AuthorizationException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'You are not allowed to do that',
                    'errors'  => new \stdClass(),
                ], 403);
            }
        });

})

->create();
