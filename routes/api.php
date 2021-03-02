<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/reservation', [\App\Http\Controllers\api\ReservationController::class, 'show'])->name('api.reservation.show');

Route::post('/reservation', [\App\Http\Controllers\api\ReservationController::class, 'store'])->name('api.reservation.store');

Route::post('/reservation/annulation/{token}', [\App\Http\Controllers\api\ReservationController::class, 'destroy'])->name('api.reservation.destroy');
