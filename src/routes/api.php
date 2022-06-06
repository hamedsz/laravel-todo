<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api/v1/todo'], function (){

    Route::get('/test', [\App\Http\Controllers\Controller::class, 'test']);

    Route::group(['prefix' => '/auth'], function (){
        Route::post('/login', [\TodoApp\app\Http\Controllers\AuthController::class, 'login']);
        Route::post('/signup' , [\TodoApp\app\Http\Controllers\AuthController::class, 'signup']);
    });

    Route::group(['middleware' => ['todo-auth']], function (){
        Route::apiResource('/tasks', \TodoApp\app\Http\Controllers\TaskController::class)->middleware('todo-auth');
        Route::apiResource('/labels', \TodoApp\app\Http\Controllers\LabelController::class);

        Route::put('/tasks/{id}/update-status', [\TodoApp\app\Http\Controllers\TaskController::class, 'updateStatus']);
        Route::put('/tasks/{id}/add-label', [\TodoApp\app\Http\Controllers\TaskController::class, 'addLabel']);
    });
});

