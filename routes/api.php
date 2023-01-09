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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->group( function () {
//     Route::apiResource('/users', App\Http\Controllers\Api\UsersController::class);
//     Route::apiResource('/barangs', App\Http\Controllers\Api\BarangController::class);
//     Route::apiResource('/event_panitias', App\Http\Controllers\Api\EventPanitiaController::class);
// });

Route::apiResource('/users', App\Http\Controllers\Api\UsersController::class);
Route::apiResource('/barangs', App\Http\Controllers\Api\BarangController::class);
Route::apiResource('/events', App\Http\Controllers\Api\EventsController::class);
Route::apiResource('/events_details', App\Http\Controllers\Api\EventDetailController::class);
Route::apiResource('/event_panitias', App\Http\Controllers\Api\EventPanitiaController::class);
