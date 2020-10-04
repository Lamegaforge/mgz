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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('logout', function () {
    Auth::logout();
})->name('logout');

Route::prefix('oauth')->middleware('guest')->as('oauth.')->group(function () {
    Route::get('login', 'OauthController@login')->name('login');
    Route::get('consume', 'OauthController@consume')->name('consume');
});

// Route::prefix('clips')->as('clips.')->group(function () {
// 	Route::get('/', 'ClipController@index')->name('index');
// 	Route::get('{id}', 'ClipController@show')->name('show');
// });

// Route::prefix('cards')->as('cards.')->group(function () {
// 	Route::get('/', 'ClipController@index')->name('index');
// 	Route::get('{id}', 'ClipController@show')->name('show');
// });
