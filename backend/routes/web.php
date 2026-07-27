<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\TeacherController;
use App\Http\Controllers\Web\ClassroomController;
use App\Http\Controllers\Web\ActivityController;

Route::get('/teste', function () {
    return view('view::teste');
});

Route::get('/', function () {
    return 200;
    //return view( 'view::home' );
});


// Rotas Basicas de recursos
Route::resource('student', StudentController::class);
Route::resource('teacher', TeacherController::class);
Route::resource('classroom', ClassroomController::class);
Route::resource('activity', ActivityController::class);