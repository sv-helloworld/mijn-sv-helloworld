<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Administrator routes
Route::group(['middleware' => ['auth', 'verified', 'account.type:admin', 'account.profile.complete']], function () {
    // Subscriptions
    Route::group(['prefix' => 'inschrijving', 'as' => 'subscription.'], function () {
        Route::get('overzicht', [
            'uses' => 'SubscriptionController@manage',
            'as' => 'manage',
        ]);

        Route::patch('{id}/goedkeuren', [
            'uses' => 'SubscriptionController@approve',
            'as' => 'approve',
        ]);

        Route::patch('{id}/weigeren', [
            'uses' => 'SubscriptionController@decline',
            'as' => 'decline',
        ]);
    });

    // Activites
    Route::group(['prefix' => 'activiteit', 'as' => 'activity.'], function () {
        Route::get('overzicht', [
            'uses' => 'ActivityController@manage',
            'as' => 'manage',
        ]);

        Route::get('aanmeldingen/{id}', [
            'uses' => 'ActivityController@entries',
            'as' => 'entries',
        ]);
    });

    // Payments
    Route::group(['prefix' => 'betaling', 'as' => 'payment.'], function () {
        Route::get('user/{id}', [
            'uses' => 'PaymentController@user',
            'as' => 'user',
        ]);
    });

    // User management routes
    Route::group(['prefix' => 'gebruikers', 'as' => 'user.'], function () {
        Route::get('leden', [
            'uses' => 'UserController@members',
            'as' => 'members',
        ]);

        Route::patch('{id}/activeren', [
            'uses' => 'UserController@activate',
            'as' => 'activate',
        ]);
    });

    Route::resource('gebruikers', 'UserController', [
        'names' => [
            'index' => 'user.index',
            'create' => 'user.create',
            'store' => 'user.store',
            'show' => 'user.show',
            'edit' => 'user.edit',
            'update' => 'user.update',
            'destroy' => 'user.destroy',
        ],
    ]);
});
