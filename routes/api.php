<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');
    Route::post('/update', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
    Route::post('/detail', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail');
    Route::post('/delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');
});
