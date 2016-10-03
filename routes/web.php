<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Protected group
Route::group(['middleware' => ['auth', 'verified', 'account.profile.complete']], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'index',
    ]);

    // Subscriptions
    Route::group(['prefix' => 'inschrijving', 'as' => 'subscription.'], function () {
        Route::get('/', [
            'uses' => 'SubscriptionController@index',
            'as' => 'index',
        ]);

        Route::get('inschrijven/{slug}', [
            'uses' => 'SubscriptionController@create',
            'as' => 'create',
        ]);

        Route::post('inschrijven/{slug}', [
            'uses' => 'SubscriptionController@store',
            'as' => 'store',
        ]);

        Route::get('{id}', [
            'uses' => 'SubscriptionController@show',
            'as' => 'show',
        ]);
    });

    // Activities
    Route::group(['prefix' => 'activiteit/aanmelding', 'as' => 'activity_entry.'], function () {
        Route::get('/', [
            'uses' => 'ActivityEntryController@index',
            'as' => 'index',
        ]);

        Route::get('{id}', [
            'uses' => 'ActivityEntryController@show',
            'as' => 'show',
        ]);

        Route::get('aanmelden/{id}', [
            'uses' => 'ActivityEntryController@create',
            'as' => 'create',
        ]);

        Route::post('aanmelden/{id}', [
            'uses' => 'ActivityEntryController@store',
            'as' => 'store',
        ]);
    });

    Route::group(['prefix' => 'activiteit', 'as' => 'activity.'], function () {
        Route::get('/', [
            'uses' => 'ActivityController@index',
            'as' => 'index',
        ]);

        Route::get('{id}', [
            'uses' => 'ActivityController@show',
            'as' => 'show',
        ]);
    });

    // Payments
    Route::group(['prefix' => 'betaling', 'as' => 'payment.'], function () {
        Route::get('/', [
            'uses' => 'PaymentController@index',
            'as' => 'index',
        ]);

        Route::get('{payment}', [
            'uses' => 'PaymentController@show',
            'as' => 'show',
        ]);

        Route::get('{payment}/factuur', [
            'uses' => 'PaymentController@invoice',
            'as' => 'invoice',
        ]);

        Route::get('{payment}/betalen', [
            'uses' => 'PaymentController@pay',
            'as' => 'pay',
        ]);

        Route::get('{payment}/betalen/callback', [
            'uses' => 'PaymentController@callback',
            'as' => 'callback',
        ]);
    });
});

// Account routes
Route::group(['middleware' => ['auth', 'account.profile.complete']], function () {
    Route::group(['as' => 'account.'], function () {
        // Account settings routes
        Route::get('account', [
            'uses' => 'Account\AccountController@index',
            'as' => 'index',
        ]);

        Route::get('account/bewerken', [
            'uses' => 'Account\AccountController@edit',
            'as' => 'edit',
        ]);

        Route::post('account/bewerken', [
            'uses' => 'Account\AccountController@update',
        ]);

        Route::get('account/gedeactiveerd', [
            'uses' => 'Account\AccountController@deactivated',
            'as' => 'deactivated',
        ]);
    });

    Route::group(['prefix' => 'account/email', 'as' => 'account.email.'], function () {
        // Edit email address routes
        Route::get('bewerken', [
            'uses' => 'Account\EmailController@edit',
            'as' => 'edit',
        ]);

        Route::post('bewerken', [
            'uses' => 'Account\EmailController@update',
            'as' => 'update',
        ]);
    });

    Route::group(['prefix' => 'account/wachtwoord', 'as' => 'account.password.'], function () {
        // Edit password routes
        Route::get('bewerken', [
            'uses' => 'Account\PasswordController@edit',
            'as' => 'edit',
        ]);

        Route::post('bewerken', [
            'uses' => 'Account\PasswordController@update',
            'as' => 'update',
        ]);
    });
});

// Authentication routes
Route::get('inloggen', [
    'uses' => 'Auth\LoginController@showLoginForm',
    'as' => 'show',
]);

Route::post('inloggen', [
    'uses' => 'Auth\LoginController@login',
    'as' => 'login',
]);

Route::get('uitloggen', [
    'uses' => 'Auth\LoginController@logout',
    'as' => 'logout',
]);

// Registration routes...
Route::get('registreren', [
    'uses' => 'Auth\RegisterController@showRegistrationForm',
    'as' => 'show',
]);

Route::post('registreren', [
    'uses' => 'Auth\RegisterController@register',
    'as' => 'register',
]);

// Account activation routes
Route::group(['prefix' => 'account/activeren', 'as' => 'account.activate.'], function () {
    Route::get('/', [
        'uses' => 'Auth\ActivationController@index',
        'as' => 'index',
    ]);

    Route::get('{token}', [
        'uses' => 'Auth\ActivationController@getVerification',
        'as' => 'token',
    ]);

    Route::get('error', [
        'uses' => 'Auth\ActivationController@getVerificationError',
        'as' => 'error',
    ]);
});

// Email verification routes
Route::group(['prefix' => 'account/email/verifieren', 'as' => 'account.email.verificate.'], function () {
    Route::get('/', [
        'uses' => 'Account\EmailController@index',
        'as' => 'index',
    ]);

    Route::get('opnieuw-versturen', [
        'uses' => 'Account\EmailController@resend',
        'as' => 'resend',
    ]);

    Route::post('opnieuw-versturen', [
        'uses' => 'Account\EmailController@resendVerification',
    ]);

    Route::get('error', [
        'uses' => 'Account\EmailController@getVerificationError',
        'as' => 'error',
    ]);

    Route::get('{token}', [
        'uses' => 'Account\EmailController@getVerification',
        'as' => 'token',
    ]);
});

// Password reset routes
Route::group(['prefix' => 'account/wachtwoord', 'as' => 'account.password.'], function () {
    // Password reset link request routes
    Route::get('email', [
        'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm',
        'as' => 'email',
    ]);

    Route::post('email', [
        'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
        'as' => 'send',
    ]);

    // Password reset routes
    Route::get('reset/{token}', [
        'uses' => 'Auth\ResetPasswordController@showResetForm',
        'as' => 'show',
    ]);

    Route::post('reset', [
        'uses' => 'Auth\ResetPasswordController@reset',
        'as' => 'reset',
    ]);

    // Password set routes
    Route::get('set/{token}', [
        'uses' => 'UserController@getReset',
        // 'as' => 'show',
    ]);

    Route::post('set', [
        'uses' => 'UserController@postReset',
        'as' => 'set',
    ]);
});
