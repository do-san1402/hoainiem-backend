<?php

use Illuminate\Support\Facades\Route;
use Modules\Reporter\Http\Controllers\ReporterController;

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

Route::group(['prefix' => 'reporter', 'middleware' => ['auth']], function () {

    Route::controller(ReporterController::class)->name('reporter.')->group(function () {

        Route::get('/reporter-list', 'index')->name('index');

        Route::get('/show', 'create')->name('create');
        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{reporter:id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');

        Route::delete('delete/{reporter:uuid}', 'destroy')->name('destroy');

        Route::put('reporter-status-edit/{reporter:uuid}', 'reporterStatusEdit')->name('reporter_status_edit');

        Route::get('/last-20-access', 'last-20-access')->name('last_20_access');
    });

});
