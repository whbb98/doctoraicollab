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
    // auth
    Route::match('GET', '/login', 'UserController@login');
    Route::match('GET', '/logout', 'UserController@logout');
    // user
    Route::resource('users', 'UserController');
    // profile
    Route::resource('profiles', 'ProfileController');
    Route::resource('careers', 'CareerController');
    Route::resource('notificationSettings', 'NotificationSettingsController');
    Route::resource('contacts', 'ContactController');
    Route::resource('notifications', 'NotificationsController');
    // posts
    Route::resource('posts', 'PostController');
    Route::match('POST', 'posts/{postID}/updatePost', 'PostController@updatePost');
    Route::match('POST', 'posts/{postID}/postInteraction', 'PostController@postInteraction');
    Route::match('POST', 'posts/{postID}/postComment', 'PostController@postComment');
    // blog
    Route::resource('blogs', 'BlogController');
    Route::match('POST', 'blogs/{blog}', 'BlogController@updateBlog');
    Route::match('DELETE', 'blogs/{blogID}/images/{imgID}', 'BlogController@deleteBlogImage');
    Route::match('DELETE', 'blogs/{blogID}/participants/{username}', 'BlogController@deleteParticipant');
    Route::match('POST', 'blogs/{blogID}/imageAnnotation', 'BlogController@ImageAnnotation');
});
