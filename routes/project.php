<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('projects')->group(function () {
        Route::put('{project}/add-member/{user}', [ProjectController::class, 'addMemberInProject']);
        Route::put('{project}/remove-member/{user}', [ProjectController::class, 'removeMemberInProject']);
        Route::get('/search', [ProjectController::class, 'search']);
        Route::delete('soft-delete/{project}/', [ProjectController::class, 'deleteSoft']);
        Route::get('/search-people-not-in-project/{project}', [ProjectController::class, 'searchPeopleNotInProject']);
    });
    Route::apiResource('projects', ProjectController::class);
});
