<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployerController;




Route::prefix('v1')->group(function(){
    Route::apiResource('employers', EmployerController::class);
    Route::apiResource('jobs', JobController::class);
    Route::apiResource('candidates', CandidateController::class);
    Route::apiResource('applications', ApplicationController::class);
    Route::apiResource('cvs', CvController::class);
});