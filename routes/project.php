<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('projects', ProjectController::class);

    Route::prefix('projects')->group(function () {
        Route::post('/addMembersInProject', [ProjectController::class, 'addMembersInProject']);
        Route::post('/removeMemberInProject', [ProjectController::class, 'removeMemberInProject']);
    });
});
