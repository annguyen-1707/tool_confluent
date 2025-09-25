<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('jwt.auth')->prefix('users')->group(function () {
    Route::apiResource('/', UserController::class);
});
