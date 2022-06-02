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
    Route::get('product/{id}', 'GuestController@showProduct')->name('product');
    Route::get('cart', 'GuestController@showCart')->name('cart');
    Route::get('transaction-history', 'GuestController@showTransactionHistory')->name('transaction-history');

    Route::post('add-to-cart', 'GuestController@postAddToCart')->name('add-to-cart');
    Route::post('checkout', 'GuestController@postCheckout')->name('checkout');

    Route::delete('remove-from-cart', 'GuestController@deleteRemoveFromCart')->name('remove-from-cart');
});

Route::prefix('hub')->name('hub.')->group(function() {
    Route::get('orders', 'HubController@showOrders')->name('orders');
    Route::get('products', 'HubController@showProducts')->name('products');
    Route::get('products/{mode}/{id?}', 'HubController@showAddEditProduct')->name('products.add-edit');

    Route::post('products/{mode}/{id?}', 'HubController@postAddEditProduct');
});
