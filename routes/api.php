<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function () {
    Route::resource('users', \App\Http\Controllers\Api\v1\UserController::class);
    Route::resource('profiles', \App\Http\Controllers\Api\v1\ProfileController::class);
    Route::resource('blogs', \App\Http\Controllers\Api\v1\BlogController::class);
});
