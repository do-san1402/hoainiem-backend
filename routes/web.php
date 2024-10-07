<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\Localize\Entities\Langstring;
use Modules\Localize\Entities\Langstrval;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ImageLibraryController;
use App\Http\Controllers\PhotoLibraryController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('dev/artisan-http/storage-link', function () {
    Artisan::call('module:asset-link');
    Artisan::call('storage:unlink');
    Artisan::call('storage:link');
});

Auth::routes();

Route::get('get-localization-strings', [LocalizationController::class, 'index'])->name('get-localization-strings');
Route::post('get-localization-strings', [LocalizationController::class, 'store']);

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard/home', [HomeController::class, 'staffHome'])->name('staffHome');
    Route::get('/dashboard/employee', [HomeController::class, 'myProfile'])->name('myProfile');
    Route::get('/dashboard/employee/edit', [HomeController::class, 'editMyProfile'])->name('editMyProfile');

    Route::get('/dashboard/profile', [HomeController::class, 'empProfile'])->name('empProfile');

    Route::get('/photo-library/view', [PhotoLibraryController::class, 'show'])->name('photo-library.view');
    Route::resource('photo-library',PhotoLibraryController::class)->except('update', 'show', 'edit');
});

//All Clear
Route::get('/all-clear', [HomeController::class, 'allClear'])->name('all_clear');

Route::get('/insert-language', function () {
    DB::table('langstrings')->truncate();
    $lang_strs = __('language');
    foreach ($lang_strs as $i => $str) {
        $lang = new Langstring();
        $lang->key = $i;
        $lang->save();
    }
    return 'Phrase Inserted Successfully..!!';
});

Route::get('/insert-language-value', function () {
    // DB::table('langstrvals')->truncate();
    $lang_strs = __('language');

    $key = 0;
    foreach ($lang_strs as $i => $str) {
        $lang = new Langstrval();
        $lang->localize_id = 2;
        $lang->langstring_id = $key + 1;
        $lang->phrase_value = $str;
        $lang->save();

        $key++;
    }

    return 'Phrase Value Inserted Successfully..!!';
});

Route::get('test1', function () {
    session()->put('test1', 'Phrase Value Inserted Successfully..!!');
    return session()->get('test1');
});
