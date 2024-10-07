<?php

use Illuminate\Support\Facades\Route;
use Modules\Archive\Http\Controllers\ArchiveController;

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

Route::group(['prefix' => 'archive', 'middleware' => ['auth']], function () {

    Route::controller(ArchiveController::class)->name('archive.')->group(function () {

        Route::get('/maximum_archive_settings_view', 'index')->name('index');

        Route::get('/show', 'create')->name('create');
        Route::post('/store', 'store')->name('store');

        Route::put('/save-max-archive-settings', 'saveMaxArchiveSettings')->name('save_max_archive_settings');

        Route::get('/archive-newses-by-category/{cat_id_available}', 'archiveNewsesByCategory')->name('archive_newses_by_category');

        Route::delete('delete/{archive:uuid}', 'destroy')->name('destroy');
    });

});
