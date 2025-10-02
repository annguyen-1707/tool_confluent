<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('logs')->group(function () {
        Route::get('/search', [LogController::class, 'search']);
    });

    Route::apiResource('logs', LogController::class);
});