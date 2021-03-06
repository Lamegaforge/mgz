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

Route::as('api.')->group(function () {
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('search', 'UserController@search')->name('search');
    });
    Route::prefix('clips')->as('clips.')->group(function () {
        Route::get('search', 'ClipController@search')->name('search');
        Route::post('reject', 'ClipController@reject')->name('reject');
    });
    Route::prefix('cards')->as('cards.')->group(function () {
        Route::get('search', 'CardController@search')->name('search');
    });
    Route::prefix('comments')->as('comments.')->group(function () {
        Route::get('user/{user_id}', 'CommentController@user')->name('user');
        Route::get('search/{clip_id}', 'CommentController@search')->name('search');
        Route::post('store', 'CommentController@store')->name('store');
    });
    Route::prefix('account')->as('account.')->group(function () {
        Route::post('update-banner', 'AccountController@updateBanner')->name('account');
        Route::post('update-user', 'AccountController@updateUser')->name('user');
    });
    Route::prefix('favorites')->as('favorites.')->group(function () {
        Route::get('search/{user_id}', 'FavoriteController@search')->name('search');
        Route::post('toggle', 'FavoriteController@toggle')->name('toggle');
    });
    Route::prefix('achievements')->as('achievement.')->group(function () {
        Route::get('search/{user_id}', 'AchievementController@search')->name('search');
    });
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::post('clip-update', 'AdminController@clipUpdate')->middleware('token')->name('clip.update');
    });
});
