<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

Route::get('/hello', [WelcomeController::class,'hello']);

Route::get('/ping', function () {
    return response()->json(['pong' => true, 'time' => now()]);
});

Route::get('/greeting/{name}',[WelcomeController::class, 'greet']);
