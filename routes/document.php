<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('documents')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working']);
    });
    Route::get('/', [DocumentController::class, 'index']);
    Route::post('/', [DocumentController::class, 'store']);
    Route::get('/{id}', [DocumentController::class, 'show']);
    Route::put('/{id}', [DocumentController::class, 'update']);
    Route::delete('/{id}', [DocumentController::class, 'destroy']);
    Route::get('/project/{projectId}', [DocumentController::class, 'getByProject']);
    Route::get('/user/{userId}', [DocumentController::class, 'getByUser']);
});
