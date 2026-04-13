<?php

use App\Modules\Setting\Actions\ChangePassword;
use App\Modules\Setting\Actions\UpdateProfile;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->group(function () {
    Route::patch('profile', UpdateProfile::class)->name('profile.update');
    Route::patch('change-password', ChangePassword::class)->name('profile.changePassword');
});
