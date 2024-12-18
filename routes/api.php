<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    // Laravel Health Route
    Route::get('/ping', function() {
        return response()->json('pong', 200);
    })->name('ping');
});
