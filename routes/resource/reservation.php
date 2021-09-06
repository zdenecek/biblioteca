<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Api\ReservationApiController;


Route::post('/reservation/make/{book}', [ReservationController::class, 'reserveBook'])
    ->middleware('auth')
    ->name('book.reserve');

Route::post('/reservation', [ReservationApiController::class, 'store'])
    ->middleware('auth');


Route::middleware("can:librarian")->group(function()
{
    Route::delete('/reservations', [ReservationController::class, 'clearReservations'])
        ->name('reservation.clear');

    Route::delete('/reservation/{reservation}', [ReservationApiController::class, 'destroy'])
        ->name('reservation.delete');

    Route::get('/aktualni-rezervace', [ReservationController::class, 'showCurrentReservations'])
        ->name('admin.reservation.current');

});
