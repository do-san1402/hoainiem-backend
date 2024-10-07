<?php

use Illuminate\Support\Facades\Route;
use Modules\Localize\Http\Controllers\LanguageController;
use Modules\Localize\Http\Controllers\LocalizeController;

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

Route::group(['prefix' => 'localize', 'middleware' => ['auth']], function () {
    Route::name('setting.localize.')->group(function () {
        Route::controller(LocalizeController::class)->group(function () {
            Route::get('/language-list', 'languagelist')->name('languagelist');
            Route::get('/language/string-list/value/{localize}', 'languageStringValueindex')->name('languageStringValueindex');
            Route::post('/', 'languageStore')->name('store');
            Route::get('/language-string-list', 'languageStringList')->name('languagestringlist');
            Route::post('/store-lang-string', 'storelanstring')->name('storelanstring');
            Route::post('/store/langstring/value', 'lanstrvaluestore')->name('lanstrvaluestore');

            Route::delete('/language-string-list/{localize:id}', 'languageStringDestroy')->name('stringDestroy');
            Route::delete('/language-list/{localize:id}', 'languageDestroy')->name('langDestroy');
        });
    });
});

Route::group(['prefix' => 'language', 'middleware' => ['auth']], function () {
    Route::name('setting.language.')->group(function () {
        Route::controller(LanguageController::class)->group(function () {

            Route::get('/language-list', 'languagelist')->name('languagelist');

            Route::get('/language/string-list/value/{id}', 'languageStringValueindex')->name('languageStringValueindex');

            Route::post('/', 'languageStore')->name('store');

            Route::get('/language-string-list', 'languageStringList')->name('languagestringlist');

            Route::post('/store-lang-string', 'storelanstring')->name('storelanstring');
            Route::post('/store/langstring/value', 'lanstrvaluestore')->name('lanstrvaluestore');

            Route::delete('/language-string-list/{language:id}', 'languageStringDestroy')->name('stringDestroy');
            Route::delete('/language-list/{language:id}', 'languageDestroy')->name('langDestroy');

            Route::get('/lang/getAllData/{id}', 'getAllData')->name('getAllData');
        });
    });
});
