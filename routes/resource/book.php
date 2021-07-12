<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CatalogController;


Route::get('/katalog', [CatalogController::class, 'showCatalog'])
->name('book.catalog');

Route::get('/kniha/{id}', [BookController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('book.detail');

Route::get('/books', [BookApiController::class, 'index'])
    ->name('book.index');

Route::middleware("can:librarian")->group(function()
{
    ////

    Route::get('/spravovat-knihy', [BookController::class, 'indexAdmin'])
        ->name('admin.book.manager');

    Route::get('/pridat-knihu', [BookController::class, 'create'])
        ->name('admin.book.add');

    Route::get('/upravit-knihu/{book}', [BookController::class, 'edit'])
        ->name('admin.book.edit');

    Route::get('/nedavno-vracene', [BorrowController::class, 'showRecentlyReturned'])
        ->name('admin.book.recently_returned');

    Route::get('/book/code/{code}',[BookController::class, "getBookByCode"])
        ->name('book.find_by_code');


    Route::get('/podrobnosti-o-knize/{id}', [BookController::class, 'showAdmin'])
        ->where('id', '[0-9]+')
        ->name('admin.book.detail');

    Route::post('/book', [BookController::class, 'store'])
        ->name('book.add');

    Route::put('/book/{book}', [BookController::class, 'update'])
        ->name('book.edit');

    Route::post('/book/{book}/borrow/{user}', [BorrowController::class, 'borrow'])
        ->name('book.borrow');

    Route::post('/book/{book}/return', [BorrowController::class, 'return'])
        ->name('book.return');

    Route::delete('/book/{book}', [BookApiController::class, 'destroy'])
        ->name('book.delete');

});
