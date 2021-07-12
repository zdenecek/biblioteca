<?php

use App\Http\Controllers\LoggedUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('can:librarian')->group(function () {
    Route::get('/uzivatele', [UserController::class, 'index'])
    ->name('admin.user.manager');

    Route::get('/detail-uzivatele/{user}', [UserController::class, 'show'])
    ->name('admin.user.detail');

    Route::get('/upravit-uzivatele/{user}', [UserController::class, 'edit'])
    ->name('admin.user.edit');

    Route::put('/user/{user}', [UserController::class, 'update'])
    ->name('user.edit');

    Route::delete('/user/{user}', [UserController::class, 'destroy'])
    ->name('user.delete');

    Route::get('/user/search/{identification}', [UserController::class, "findUserByCodeOrEmail"])
    ->name('user.find_by_code_or_email');
});

Route::name("user.")->middleware('auth')->group(function() {

    Route::get('/me-vypujcky', [LoggedUserController::class, 'showCurrentBorrowsReservations'])
        ->name('current_borrows_reservations');

    Route::get('/me-nastaveni', [LoggedUserController::class, 'showSettings'])
        ->name('settings');

    Route::get('/muj-kod', [LoggedUserController::class, 'showCode'])
        ->name('code');

    Route::put('/zmenit-heslo', [LoggedUserController::class, 'changePassword'])
        ->name('change_password');

    Route::put('/zmenit-email', [LoggedUserController::class, 'changeEmail'])
        ->name('change_email');

});