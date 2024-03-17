<?php

use App\Modules\Auth\Controllers\AuthenticatedTokenController;
use App\Modules\Auth\Controllers\CurrentUserController;
use App\Modules\Auth\Controllers\NewPasswordController;
use App\Modules\Auth\Controllers\PasswordResetLinkController;
use App\Modules\Auth\Controllers\RegisteredUserController;
use App\Modules\Auth\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::withoutMiddleware('auth:sanctum')->group(function () {

        Route::post('login', [AuthenticatedTokenController::class, 'store'])->name('login');
        Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('forgot-password');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('reset-password');

    });

    Route::post('email/verify/{user}', [VerifyEmailController::class, 'verify'])
        ->middleware(['throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/resend', [VerifyEmailController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');

    Route::post('logout', [AuthenticatedTokenController::class, 'destroy'])->name('logout');
    Route::post('me', CurrentUserController::class)->name('me');
});
