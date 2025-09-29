<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NodeController;

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('nodes')->group(function () {
        Route::get('/search', [NodeController::class, 'search']);
    });

    Route::apiResource('nodes', NodeController::class);
});