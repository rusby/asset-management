<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('barangs/list', [BarangController::class, 'getBarangs'])->name('barangs.list');
Route::resource('barangs', App\Http\Controllers\BarangController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::g et('barangs', [App\Http\Controllers\BarangController::class, 'index'])->name('barangs.index');
