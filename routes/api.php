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

//Api Routes V1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function () {
    Route::match('GET', '/login', 'UserController@login');
    Route::match('GET', '/logout', 'UserController@logout');
    Route::resource('users', 'UserController');
    Route::resource('profiles', 'ProfileController');
    Route::resource('blogs', 'BlogController');
    Route::resource('careers', 'CareerController');
    Route::resource('notificationSettings', 'NotificationSettingsController');
    Route::resource('contacts','ContactController');
});
