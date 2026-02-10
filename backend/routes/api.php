<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->group(function () {

//  Auth endpoints
    Route::prefix('/auth')->name('auth.')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:60,1')->name('register');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:60,1')->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('throttle:60,1')->name('logout');
    });


});