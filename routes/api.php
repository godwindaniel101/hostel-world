<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;

Route::post('register', [RegistrationController::class, 'register']); //create new user data
Route::post('login', [LoginController::class, 'login']); //generate access token for new user

Route::middleware('auth:api')->group(function () { 
    Route::delete('logout', [LoginController::class, 'logout']);//invalidate access token
    Route::get('events', [EventController::class, 'eventsFromDB']);
    Route::get('events_json', [EventController::class, 'eventsFromJSON']);
});

