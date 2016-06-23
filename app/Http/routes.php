<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses' => 'IndexController@index',
    'as' => 'index',
]);

// Authentication routes
Route::get('inloggen', [
    'uses' => 'Auth\AuthController@getLogin',
    'as' => 'login',
]);

Route::post('inloggen', [
    'uses' => 'Auth\AuthController@postLogin',
]);

Route::get('uitloggen', [
    'uses' => 'Auth\AuthController@getLogout',
    'as' => 'logout',
]);

// Password reset routes
Route::group(['prefix' => 'account/wachtwoord', 'as' => 'account.password.'], function () {
    // Password reset link request routes
    Route::get('email', [
        'uses' => 'Auth\PasswordController@getEmail',
        'as' => 'email',
    ]);

    Route::post('email', [
        'uses' => 'Auth\PasswordController@postEmail',
    ]);

    // Password reset routes
    Route::get('reset/{token}', [
        'uses' => 'Auth\PasswordController@getReset',
        'as' => 'reset',
    ]);

    Route::post('reset', [
        'uses' => 'Auth\PasswordController@postReset',
    ]);
});
