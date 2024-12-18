<?php

use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    Route::prefix('logs')->name('logs.')->group(function() {
        Route::controller(LogController::class)->group(function() {
            Route::post('/process', 'process')->name('process');
        });
    });

    // Laravel Health Route
    Route::get('/ping', function() {
        return response()->json('pong', 200);
    })->name('ping');
});
