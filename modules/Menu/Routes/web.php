<?php
use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\MenuController;
use Modules\Menu\Http\Controllers\MenuSetupController;

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
    Route::get('menu/setup/{menu}', [MenuSetupController::class, 'create'])->name('menu.setup.create');
    Route::get('menu/setup/{menu}/edit/{menu_content}', [MenuSetupController::class, 'edit'])->name('menu.setup.edit');
    Route::patch('menu/setup/{menu}/update/{menu_content}', [MenuSetupController::class, 'update'])->name('menu.setup.update');
    Route::delete('menu/setup/{menu}/destroy/{menu_content}', [MenuSetupController::class, 'destroy'])->name('menu.setup.destroy');
    Route::patch('menu/setup/{menu}/update-position', [MenuSetupController::class, 'updatePosition'])->name('menu.setup.update-position');
    Route::post('menu/setup/{menu}/store-category-menu-content', [MenuSetupController::class, 'storeCategoryMenuContent'])->name('menu.setup.storeCategoryMenuContent');
    Route::post('menu/setup/{menu}/store-page-menu-content', [MenuSetupController::class, 'storePageMenuContent'])->name('menu.setup.storePageMenuContent');
    Route::post('menu/setup/{menu}/store-link-menu-content', [MenuSetupController::class, 'storeLinkMenuContent'])->name('menu.setup.storeLinkMenuContent');
    Route::post('menu/setup/{menu}/store-link', [MenuSetupController::class, 'storeLink'])->name('menu.setup.storeLink');

    Route::patch('menu/{menu}/update-status', [MenuController::class, 'updateStatus'])->name('menu.update-status');
    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');

});
