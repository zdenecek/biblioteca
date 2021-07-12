<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookCollectionController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExportDatabaseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImportDatabaseController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StickerController;

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


//TINYMCE

Route::post('/img/upload', [ImageController::class, "upload"]);

//SCHEDULE

Route::get('/cron', [ScheduleController::class, "run"]);

//PUBLIC

Route::get('/', [ArticleController::class, "showDashboard"])
    ->name('dashboard');

Route::get('/knihovni-rad', [ArticleController::class, 'ShowRules'])
    ->name('rules');


//ADMIN

Route::get('/instalace', [AdminController::class, 'install']);

Route::middleware('can:admin')->group(function () {
    Route::get('/artisan', [AdminController::class, 'showArtisan'])
        ->name('admin.artisan');

    Route::post('/artisan', [AdminController::class, 'postArtisan'])
        ->name('admin.artisan');

    Route::get('/nastaveni-webu', [AdminController::class, 'showSettings'])
        ->name('admin.web_settings');

    Route::put('/zmenit-nastaveni-webu', [AdminController::class, 'editSettings'])
        ->name('admin.edit_web_settings');

    Route::put('/zmenit-nastaveni-webu', [AdminController::class, 'editSettings'])
        ->name('admin.edit_web_settings');

    //EMAILS

    Route::get('/emaily', [EmailController::class, 'showDashboard'])
    ->name('admin.email.dashboard');

    //BOOK COLLECTIONS

    Route::get('/pridat-sbirku', [BookCollectionController::class, 'showAddBookCollection'])
    ->name('admin.book_collection.add');

    Route::get('/upravit-sbirku/{collection}', [BookCollectionController::class, 'showEditBookCollection'])
        ->name('admin.book_collection.edit');

    //STICKERS

    Route::get('/pridat-nalepku', [StickerController::class, 'showAddSticker'])
    ->name('admin.sticker.add');

    Route::get('/upravit-nalepku/{sticker}', [StickerController::class, 'showEditSticker'])
        ->name('admin.sticker.edit');


    Route::delete('/sticker/{sticker}', [StickerController::class, 'destroy'])
        ->name('admin.sticker.delete');

    //DB
    Route::get('/database/export', [ExportDatabaseController::class, 'export'])
        ->name('db.export');

    Route::get('/export', [ExportDatabaseController::class, 'showExport'])
        ->name('admin.db.export');

    Route::get('/import', [ImportDatabaseController::class, 'showImport'])
        ->name('admin.db.import');

    Route::post('/import', [ImportDatabaseController::class, 'importBooks'])
        ->name('db.import');

    Route::get('/historie-importu', [ImportDatabaseController::class, 'showImportHistory'])
        ->name('admin.db.import_history');
});

//LIBRARIAN

Route::middleware('can:librarian')->group(function () {

    Route::get('/administrace',  [AdminController::class ,"showDashboard"])
        ->name('admin.dashboard');

    //DASHBOARD

    Route::get('/upravit-nastenku', [ArticleController::class, "showEditDashboard"])
        ->name('admin.edit_dashboard');

    //RULES

    Route::get('/upravit-knihovni-rad', [ArticleController::class, "showEditRules"])
        ->name('admin.edit_rules');


    //BORROWS
    Route::get('/pujcit-nebo-vratit', [BorrowController::class, "borrowOrReturn"])
    ->name('admin.book.borrow_or_return');


    Route::get('/aktualni-vypujcky', [BorrowController::class, 'ShowCurrentBorrows'])
        ->name('admin.borrow.current');


    //BOOK COLLECTION

    Route::post('/collection', [BookCollectionController::class, 'addBookCollection'])
        ->name('book_collection.add');

    Route::put('/collection/{collection}', [BookCollectionController::class, 'editBookCollection'])
        ->name('book_collection.edit');

    //STICKER

    Route::post('/sticker', [StickerController::class, 'addSticker'])
        ->name('sticker.add');

    Route::put('/sticker/{sticker}', [StickerController::class, 'editSticker'])
        ->name('sticker.edit');


    // ARTICLE
    Route::put('/upravit-nastenku', [ArticleController::class, "editDashboard"] )
        ->name('edit_dashboard');

    Route::put('/upravit-knihovni-rad', [ArticleController::class, "editRules"] )
        ->name('edit_rules');
});


require __DIR__.'/resource/book.php';
require __DIR__.'/resource/reservation.php';
require __DIR__.'/resource/user.php';

require __DIR__.'/auth.php';
