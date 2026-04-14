<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * This route needs to be at the end of the file
 */
Route::view('/{any}', 'spa')->where('any', '^(?!api).*');
