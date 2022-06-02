<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api/v1/todo'], function (){

    Route::get('/test', function (){
        return 'ok';
    });

    Route::group(['prefix' => '/auth'], function (){
        Route::post('/login');
        Route::post('/signup');
    });

    Route::apiResource('/tasks', \TodoApp\app\Http\Controllers\TaskController::class);
    Route::apiResource('/labels', \TodoApp\app\Http\Controllers\LabelController::class);
});

