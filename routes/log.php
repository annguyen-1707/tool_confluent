<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

Route::middleware('jwt.auth')->group(function () {
    Route::prefix('logs')->group(function () {
        Route::get('/', [LogController::class, 'index']);
        Route::get('/my-logs', [LogController::class, 'myLogs']);
        Route::get('/project/{projectId}', [LogController::class, 'projectLogs']);
        Route::get('/{id}', [LogController::class, 'show']);
        Route::post('/', [LogController::class, 'store']);
    });
});
