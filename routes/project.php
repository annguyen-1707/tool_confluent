<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::middleware('jwt.auth')->prefix('projects')->group(function () {
    Route::apiResource('/', ProjectController::class);
    // Route::post('', );
});
