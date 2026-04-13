<?php

use App\Modules\Auth\Actions\ForgotPassword;
use App\Modules\Auth\Actions\GetCurrentUser;
use App\Modules\Auth\Actions\Login;
use App\Modules\Auth\Actions\Logout;
use App\Modules\Auth\Actions\Register;
use App\Modules\Auth\Actions\ResendVerificationEmail;
use App\Modules\Auth\Actions\ResetPassword;
use App\Modules\Auth\Actions\VerifyEmail;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::withoutMiddleware('auth:sanctum')->group(function () {

        Route::post('login', Login::class)->name('login');
        Route::post('register', Register::class)->name('register');

        Route::post('forgot-password', ForgotPassword::class)->name('forgot-password');
        Route::post('reset-password', ResetPassword::class)->name('reset-password');

    });

    Route::post('email/verify/{user}', VerifyEmail::class)
        ->middleware(['throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/resend', ResendVerificationEmail::class)
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');

    Route::post('logout', Logout::class)->name('logout');
    Route::post('me', GetCurrentUser::class)->name('me');
});
