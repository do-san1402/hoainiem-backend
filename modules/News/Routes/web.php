<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\NewsController;
use Modules\News\Http\Controllers\NewsPositionController;
use Modules\News\Http\Controllers\BreakingNewsController;
use Modules\News\Http\Controllers\NewsPostController;

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

Route::group(['middleware' => ['auth']], function () {
    Route::get('news/position', [NewsPositionController::class, 'index'])->name('news.position.index');
    Route::patch('news/position/update', [NewsPositionController::class, 'update'])->name('news.position.update');
    Route::delete('news/position/{news_position}/destroy', [NewsPositionController::class, 'destroy'])->name('news.position.destroy');

    Route::resource('news/breaking-news', BreakingNewsController::class)->names('news.breaking-news')->except(['create', 'show']);

    Route::resource('news/post', NewsPostController::class)->names('news.post')->except(['show']);

    Route::post('news/store-report', [NewsController::class, 'storeReport'])->name('news.storeReport');
    Route::patch('news/{news}/update-status', [NewsController::class, 'updateStatus'])->name('news.update-status');
    Route::resource('news', NewsController::class);
});
