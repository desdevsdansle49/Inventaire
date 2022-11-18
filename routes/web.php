<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\PostController::class, 'tableau']);
Route::get('/stats', [\App\Http\Controllers\PostController::class, 'stats']);
Route::get('/alerts', [\App\Http\Controllers\PostController::class, 'alerts']);

Route::get('/infophp', function () {
    return phpinfo();
});