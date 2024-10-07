<?php

use Modules\Seo\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'seo', 'middleware' => ['auth']], function () {

    Route::controller(SeoController::class)->name('seo.')->group(function () {

        Route::get('/meta-setting', 'index')->name('index');
        Route::post('/store', 'store')->name('store');

        Route::get('/social-sites', 'socialSites')->name('social_sites');
        Route::post('/social-site-store', 'socialSiteStore')->name('social_site_store');

        Route::get('/social-link', 'socialLink')->name('social_link');
        Route::post('/social-link-store', 'socialLinkStore')->name('social_link_store');
    });

});
