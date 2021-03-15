<?php

declare(strict_types=1);

use CzechitasApp\Http\Controllers\Api\Auth\ProfileController;
use CzechitasApp\Http\Controllers\Api\CategoryController;
use CzechitasApp\Http\Controllers\Api\OrderController;
use CzechitasApp\Http\Controllers\Api\TermController;
use CzechitasApp\Http\Controllers\HomeController;
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

Route::post('orders', [OrderController::class, 'store']);
Route::post('users/register', [ProfileController::class, 'register']);
Route::get('categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(static function (): void {
    // resources: index, show, store, update, destroy
    Route::apiResource('terms', TermController::class, []);

    Route::get('users/current', [ProfileController::class, 'current']);
});

Route::fallback([HomeController::class, 'apiError404']);
