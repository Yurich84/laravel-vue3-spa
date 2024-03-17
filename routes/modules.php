<?php

use Illuminate\Support\Facades\Route;

if (! defined('API_PREFIX')) {
    define('API_PREFIX', 'v1');
}

$modules_folder = app_path('Modules');
$modules = array_values(
    array_filter(
        scandir($modules_folder),
        fn ($item) => is_dir($modules_folder.DIRECTORY_SEPARATOR.$item) && ! in_array($item, ['.', '..'])
    )
);

foreach ($modules as $module) {
    $routesPath = $modules_folder.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'routes_api.php';

    if (file_exists($routesPath)) {
        Route::prefix(API_PREFIX)
            ->middleware(['auth:sanctum'])
            ->namespace("\\App\\Modules\\$module\Controllers")
            ->group($routesPath);
    }
}
