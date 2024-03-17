<?php

use Illuminate\Support\Facades\Route;

/**
 * This route needs to be at the end of the file
 */
Route::view('/{any}', 'spa')->where('any', '^(?!api).*');
