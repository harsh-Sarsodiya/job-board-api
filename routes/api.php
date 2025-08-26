<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Authenticated routes
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        // Job routes
        Route::get('/jobs', [JobController::class, 'index']);
        Route::get('/jobs/{job}', [JobController::class, 'show']);
        Route::post('/jobs', [JobController::class, 'store']);
        Route::put('/jobs/{job}', [JobController::class, 'update']);
        Route::delete('/jobs/{job}', [JobController::class, 'destroy']);
        Route::get('/my-jobs', [JobController::class, 'myJobs']);

        // Admin job routes
        Route::middleware('can:updateStatus,job')->group(function() {
            Route::get('/pending-jobs', [JobController::class, 'pendingJobs']);
            Route::post('/jobs/{job}/status', [JobController::class, 'updateStatus']);
        });

        // Application routes
        Route::get('/applications', [ApplicationController::class, 'index']);
        Route::get('/applications/{application}', [ApplicationController::class, 'show']);
        Route::post('/applications', [ApplicationController::class, 'store']);
        Route::post('/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy']);
    });
});
