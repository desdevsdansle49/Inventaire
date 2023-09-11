<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\MainController::class, 'mainTable']);
Route::get('/stats', [\App\Http\Controllers\MainController::class, 'stats']);
Route::get('/logs', [\App\Http\Controllers\MainController::class, 'logs']);
Route::get('/create', [\App\Http\Controllers\MainController::class, 'mainTable']);
Route::get('/catTab', [\App\Http\Controllers\MainController::class, 'addTable']);

// Route::get('/infophp', function () {
//     return phpinfo();
// });