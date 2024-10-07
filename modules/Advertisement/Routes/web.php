<?php

use Illuminate\Support\Facades\Route;
use Modules\Advertisement\Http\Controllers\AdvertisementController;

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

Route::group(['prefix' => 'advertise', 'middleware' => ['auth']], function () {

    Route::controller(AdvertisementController::class)->name('advertise.')->group(function () {

        Route::get('/view_ads', 'index')->name('index');

        Route::get('/show', 'create')->name('create');
        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{advertise:id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');

        Route::delete('delete/{advertise:uuid}', 'destroy')->name('destroy');

        Route::put('/ad/update_lg_status/{advertise:uuid}', 'updateLgStatus')->name('update_lg_status');
        Route::put('/ad/update_sm_status/{advertise:uuid}', 'updateSmStatus')->name('update_sm_status');
    });

});
