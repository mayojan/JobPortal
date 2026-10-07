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
           $exceptions->render(function (
        \Illuminate\Database\Eloquent\ModelNotFoundException $e,
        \Illuminate\Http\Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Resource not found',
                'errors'  => new \stdClass(),
            ], 404);
        }
    });

    $exceptions->render(function (
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
        \Illuminate\Http\Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Endpoint not found',
                'errors'  => new \stdClass(),
            ], 404);
        }
    });
})

->create();
