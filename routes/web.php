<?php

use App\Utilities\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/health', function () {
    return response()->json(["message" => "health check all good"]);
});
Route::get('/er', function () {
    return view('er');
});


Route::fallback(function (Request $request) {
    return (new Helpers())->errorResponder(null, 404, 'Route [ ' . $request->url() . ' ] Not Found');
});
