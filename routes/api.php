<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api', 'prefix' => '/v1'], function () {
    /**
     * User API endpoints
     */
    Route::get('user/{id}', 'API\UserAPIController@show');
    Route::post('user/{id}', 'API\UserAPIController@update');
});

/**
 * These are all routes which do not need to be authenticated
 */
Route::group(['middleware' => [], 'prefix' => '/v1'], function () {
    /**
     * Address API endpoints
     */
    Route::get('address', 'API\AddressController@get');
});
