<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('projects', ProjectController::class);

    Route::prefix('projects')->group(function () {
        Route::put('{project}/add-members', [ProjectController::class, 'addMembersInProject']);
        Route::put('{project}/remove-member/{user}', [ProjectController::class, 'removeMemberInProject']);
    });
});
