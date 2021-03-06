<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('logout', 'HomeController@logout')->name('logout');

Route::prefix('oauth')->middleware('guest')->as('oauth.')->group(function () {
	Route::get('login', 'OauthController@login')->name('login');
    Route::get('consume', 'OauthController@consume')->name('consume');
});

Route::prefix('clips')->as('clips.')->group(function () {
	Route::get('/', 'ClipController@index')->name('index');
	Route::get('random', 'ClipController@random')->name('index');
    Route::get('{hook}', 'ClipController@show')->name('show');
});

Route::prefix('cards')->as('cards.')->group(function () {
	Route::get('/', 'CardController@index')->name('index');
	Route::get('{hook}', 'CardController@show')->name('show');
});

Route::prefix('users')->as('users.')->group(function () {
	Route::get('/', 'UserController@index')->name('index');
	Route::get('account', 'UserController@account')->middleware('auth')->name('account');
	Route::get('account/settings', 'UserController@settings')->middleware('auth')->name('settings');
	Route::get('notifications', 'UserController@notifications')->middleware('auth')->name('notifications');
	Route::get('{hook}', 'UserController@show')->name('show');
});
