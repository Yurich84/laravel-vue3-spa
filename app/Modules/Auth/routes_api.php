<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::withoutMiddleware('auth:sanctum')->group(function () {
        Route::post('login', 'LoginController@login')->name('login');
        Route::post('register', 'RegisterController@register')->name('register');

        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.reset-email');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');

        Route::post('email/verify/{user}', 'VerificationController@verify')->name('verification.verify');
        Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
    });

    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::post('me', 'UserController@me')->name('me');
});
