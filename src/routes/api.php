<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api/v1/todo'], function (){

    Route::get('/test', [\App\Http\Controllers\Controller::class, 'test']);

    Route::group(['prefix' => '/auth'], function (){
        Route::post('/login');
        Route::post('/signup');
    });

    Route::apiResource('/tasks', \TodoApp\app\Http\Controllers\TaskController::class)->middleware('todo-auth');
    Route::apiResource('/labels', \TodoApp\app\Http\Controllers\LabelController::class);
});

