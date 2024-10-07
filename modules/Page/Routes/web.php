<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;

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

Route::group(['prefix' => 'page', 'middleware' => ['auth']], function () {

    Route::controller(PageController::class)->name('page.')->group(function () {

        Route::get('/pages', 'index')->name('index');

        Route::get('/create-new-page', 'create')->name('create');
        Route::post('/store', 'store')->name('store');

        Route::get('/edit/{page:id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::put('/page/update-page-status/{page:uuid}', 'updatePageStatus')->name('update_page_status');

        Route::delete('delete/{page:uuid}', 'destroy')->name('destroy');

        // Ckeditor routes to upload image
        Route::post('page/ckeditor_upload', 'upload_ckeditor_data')->name('ckeditor_upload');
    });

});
