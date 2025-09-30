<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('jwt.auth')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/search', [UserController::class, 'search']);
    });
    Route::apiResource('users', UserController::class);
});