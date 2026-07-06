<?php

use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return view('view::teste');
});

// Rotas basicas