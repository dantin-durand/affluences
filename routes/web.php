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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');
Route::post('/', [\App\Http\Controllers\IndexController::class, 'postIndex'])->name('index.send');

Route::get('/reservation', [\App\Http\Controllers\ReservationController::class, 'reservation'])->name('reservation');

Route::post('/reservation', [\App\Http\Controllers\ReservationController::class, 'sendReservation'])->name('reservation.send');

Route::post('/reservation/annulation/{token}', [\App\Http\Controllers\ReservationController::class, 'sendRemoveReservation'])->name('reservation.remove.send');

Route::get('/reservation/annulation/{token}', [\App\Http\Controllers\ReservationController::class, 'removeReservation'])->name('reservation.remove');
