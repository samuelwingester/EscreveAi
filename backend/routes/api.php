<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ActivityController;

use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;

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


/*
Route::apiResource( 'student', StudentController::class )->middleware( 'auth:sanctum' );
Route::apiResource( 'teacher', TeacherController::class )->middleware( 'auth:sanctum' );
Route::apiResource( 'classroom', ClassroomController::class )->middleware( 'auth:sanctum' );
Route::apiResource( 'activity', ActivityController::class )->middleware( 'auth:sanctum' );
*/

Route::middleware( 'auth:sanctum' )->group( function () {
    Route::apiResources([
        'student'   => StudentController::class, 
        'teacher'   => TeacherController::class, 
        'classroom' => ClassroomController::class, 
        'activity'  => ActivityController::class 
    ]);
});

// Rotas de Login
Route::controller( AuthController::class )->group( function () {
    Route::post( '/login', 'login' );
    Route::post( '/register', 'register' );
    
    Route::post( '/logout', 'logout' )->middleware( 'auth:sanctum' );
    Route::get( '/user', 'user' )->middleware( 'auth:sanctum' );
});