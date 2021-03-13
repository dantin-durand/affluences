<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/config', [\App\Http\Controllers\api\ReservationController::class, 'show'])->name('api.reservation.show');

Route::get('/reservation/{date}', [\App\Http\Controllers\api\ReservationController::class, 'showReservations'])->name('api.reservation.showReservations');

Route::post('/reservation', [\App\Http\Controllers\api\ReservationController::class, 'store'])->name('api.reservation.store');


Route::delete('/reservation/annulation/{token}', [\App\Http\Controllers\api\ReservationController::class, 'destroy'])->name('api.reservation.destroy');
