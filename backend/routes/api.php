<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TurmaController;

Route::fallback(function () 
{
    // Implementar depois. fallback das rotas da api 
});

Route::get('/routes', function () 
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

Route::apiResource('turma', TurmaController::class);
