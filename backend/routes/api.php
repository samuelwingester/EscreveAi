<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ActivityController;

use App\Http\Controllers\AuthController;

Route::get('/', function ()
{
    //retorna as rotas existentes da api e os metodos aceitos de cada uma
    $routes = collect(Route::getRoutes())->filter( function ($route) {
        return in_array('api', $route->gatherMiddleware());
    })->map( function ($route) {
        return [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'name' => $route->getName()
        ];
    });

    return response()->json($routes);
})->name('routes');

Route::middleware( 'auth:sanctum' )->group( function () {
    Route::apiResources([
        'classroom/{classroom}/student' => StudentController::class,
        'classroom/{classroom}/activity'  => ActivityController::class,
        'classroom' => ClassroomController::class
    ]);

    Route::controller( ClassroomController::class )->group( function () {
        Route::get( '/classroom/{classroom}/stats', 'stats' );
        // Route::get( '/classroom/stats', 'summary' ); // IMPLEMENTAR
    });
});

// Rotas de Login
Route::controller( AuthController::class )->group( function () {
    Route::post( '/login', 'login' );
    Route::post( '/register', 'register' );
    Route::put( '/change_password', 'change_password' )->middleware( 'auth:sanctum' );

    Route::post( '/logout', 'logout' )->middleware( 'auth:sanctum' );
    Route::get( '/user', 'user' )->middleware( 'auth:sanctum' );
    Route::delete( '/user', 'delete' )->middleware( 'auth:sanctum' );
    Route::match( [ 'put', 'patch'], '/user', 'update' )->middleware( 'auth:sanctum' );
});
