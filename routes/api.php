<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AuthenticationController;

Route::post('register', [AuthenticationController::class, 'register']); //create new user data
Route::post('login', [AuthenticationController::class, 'login']); //generate access token for new user

Route::middleware('auth:api')->group(function () { 
    Route::delete('logout', [AuthenticationController::class, 'logout']);//invalidate access token
    Route::get('events', [EventController::class, 'index']);
    Route::get('events_v2', [EventController::class, 'indexTwo']);
});

