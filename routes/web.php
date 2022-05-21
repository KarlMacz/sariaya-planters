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

Route::name('auth.')->group(function() {
    Route::get('login', 'AuthController@showLogin')->name('login');
    Route::get('register', 'AuthController@showRegister')->name('register');

    Route::post('login', 'AuthController@postLogin');
    Route::post('logout', 'AuthController@postLogout')->name('logout');
    Route::post('register', 'AuthController@postRegister');
});

Route::name('guest.')->group(function() {
    Route::get('/', 'GuestController@showIndex')->name('index');
    Route::get('shop', 'GuestController@showShop')->name('shop');
    Route::get('test', 'GuestController@showTest');
});
