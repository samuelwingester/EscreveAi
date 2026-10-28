<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use App\Exceptions\InvalidCredentialsException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render( function ( InvalidCredentialsException $e, Request $request ){
            return response()->json([ 'message' => 'credenciais invalidas.' ], 401);
        });

        $exceptions->render( function ( AuthenticationException $e, $request ){
            return response()->json([ 'message' => 'Não autenticado.' ], 401);
        });

    })->create();
