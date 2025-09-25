<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('notes', NoteController::class);
});
