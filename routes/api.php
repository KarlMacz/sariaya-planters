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

Route::middleware('api')->name('api.')->group(function() {
    Route::post('fetch/province', 'ApiController@fetchProvinces')->name('fetch.province');
    Route::post('fetch/municipality', 'ApiController@fetchMunicipalities')->name('fetch.municipality');
    Route::post('fetch/barangay', 'ApiController@fetchBarangays')->name('fetch.barangay');
});
