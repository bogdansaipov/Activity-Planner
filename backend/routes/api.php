<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\TelegramWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->group(function () {

//  Auth endpoints
    Route::prefix('/auth')->name('auth.')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:60,1')->name('register');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:60,1')->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('throttle:60,1')->name('logout');
    });

    Route::middleware('auth:sanctum')->prefix('events')->group(function () {

    Route::get('/', [EventController::class, 'index']);        // list
    Route::post('/', [EventController::class, 'store']);       // create
    Route::get('/{id}', [EventController::class, 'show']);     // single
    Route::put('/{id}', [EventController::class, 'update']);   // update
    Route::delete('/{id}', [EventController::class, 'destroy']); // delete

    Route::patch('/{id}/complete', [EventController::class, 'complete']); // action
});

Route::post('/telegram/webhook', TelegramWebhookController::class);


});