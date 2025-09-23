<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::apiResource('users', UserController::class);
Route::apiResource('auths', AuthController::class);

require __DIR__.'/auth.php';
