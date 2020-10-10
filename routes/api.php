<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('clips')->as('clips.')->group(function () {
	Route::get('search', 'ClipController@search')->name('search');
});

Route::prefix('comments')->as('comments.')->group(function () {
	Route::get('store', 'CommentController@store')->name('store');
});
