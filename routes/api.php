<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

Route::get('/hello', [WelcomeController::class,'hello']);

Route::get('/ping', function () {
    return response()->json(['pong' => true, 'time' => now()]);
});

Route::get('/greeting/{name}',[WelcomeController::class, 'greet']);
Route::apiResource('employers', EmployerController::class);
Route::apiResource('jobs', JobController::class);
Route::apiResource('candidates', CandidateController::class);
Route::apiResource('applications', ApplicationController::class);
Route::apiResource('cvs', CvController::class);