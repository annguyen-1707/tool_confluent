<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NodeController;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('nodes', NodeController::class);
});
