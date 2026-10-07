<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CvController;

Route::prefix('v1')->group(function () {

    //  مسیرهای عمومی (بدون نیاز به توکن) 
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

    //  مسیرهای محافظت‌شده (حتماً نیاز به توکن دارند)
    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('/logout',[AuthController::class, 'logout']);
        Route::get('/me',fn (Request $request) => $request->user());

        // تمام ریسورس‌های جدول‌های که از قبل ساخته بودیم:
        Route::apiResource('employers',EmployerController::class);
        Route::apiResource('jobs',JobController::class);
        Route::apiResource('candidates',CandidateController::class);
        Route::apiResource('applications',ApplicationController::class);
        Route::apiResource('cvs',CvController::class);
    });

});
