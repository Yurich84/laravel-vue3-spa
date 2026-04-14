<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/modules.php';

Route::middleware(['auth:sanctum'])->get('/user', fn (Request $request) => $request->user());
