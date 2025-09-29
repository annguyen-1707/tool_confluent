<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('users', UserController::class);
});
