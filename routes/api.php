<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    Route::prefix('logs')->name('logs.')->group(function() {
        Route::controller(LogController::class)->group(function() {
            Route::post('/process', 'process')->name('process');
        });
    });

    Route::prefix('reports')->name('reports.')->group(function() {
        Route::controller(ReportController::class)->group(function() {
            Route::get('/requests-by-consumer', 'processRequestsByConsumerReport')->name('requests-by-consumer');
            Route::get('/requests-by-service', 'processRequestsByServiceReport')->name('requests-by-service');
            Route::get('/average-times-by-service', 'processAverageTimesByServiceReport')->name('average-times-by-service');
        });
    });


    // Laravel Health Route
    Route::get('/ping', function() {
        return response()->json('pong', 200);
    })->name('ping');
});
