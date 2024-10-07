<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\ZktController;
use Modules\Setting\Http\Controllers\BackupController;
use Modules\Setting\Http\Controllers\CountryController;
use Modules\Setting\Http\Controllers\SettingController;
use Modules\Setting\Http\Controllers\ApplicationController;
use Modules\Setting\Http\Controllers\DocExpiredSettingController;
use Modules\Setting\Http\Controllers\ViewSetupController;
use Modules\Setting\Http\Controllers\CommentsInfoController;
use Modules\Setting\Http\Controllers\SubscriptionController;
use Modules\Setting\Http\Controllers\SpaceCredentialController;

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/settings', [SettingController::class, 'settings'])->name('settings');
    Route::get('/applications', [ApplicationController::class, 'application'])->name('applications.application');
    Route::post('/applications/{id:id}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::get('/apps', [ApplicationController::class, 'appSetting'])->name('app.index');
    Route::post('/apps', [ApplicationController::class, 'updateAppSetting'])->name('app.update');

    Route::resource('currencies', 'CurrencyController');
    Route::resource('mails', 'MailController');
    Route::resource('countries', CountryController::class);

    Route::patch('space-credential/{space_credential}/update-status', [SpaceCredentialController::class, 'updateStatus'])->name('space-credential.update-status');
    Route::resource('space-credential', SpaceCredentialController::class);
});


Route::prefix('database-backup-reset')->as('backup.')->middleware('auth')->group(function () {
    Route::get('/', [BackupController::class, 'index'])->name('index');
    Route::post('/create', [BackupController::class, 'createBackup'])->name('create');
    Route::get('/download', [BackupController::class, 'download'])->name('download');
    Route::delete('/delete', [BackupController::class, 'destroy'])->name('delete');
    Route::delete('/delete-all', [BackupController::class, 'destroyAll'])->name('delete.all');

    //Factory Reset
    Route::post('/factory-reset',  [BackupController::class, 'factoryReset'])->name('factory_reset');

    //Database Import
    Route::post('/database-import',  [BackupController::class, 'databaseImport'])->name('database_import');
    Route::post('/database-import-by-name',  [BackupController::class, 'databaseImportByName'])->name('database_import_by_name');
    Route::post('/password-check',  [BackupController::class, 'passwordCheck'])->name('password_check');
});

Route::group(['prefix' => 'setting', 'middleware' => 'auth'], function () {
    Route::name('sale.')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('/sale-settings', 'sale_settings')->name('setting.index');
            Route::post('/store-sale-settings', 'store_sale_settings')->name('setting.store');
            Route::get('/tax-settings', 'tax_settings')->name('setting.tax');
            Route::get('/get-tax-settings', 'getTaxSettings')->name('setting.tax.get');
            Route::get('/get-tax-settings-for-group', 'getTaxSettingsForTaxGroup')->name('setting.tax.for.group');
            Route::post('/save-tax-settings', 'store_tax_settings')->name('setting.tax.store');
            Route::post('/store-tax-group', 'store_tax_group')->name('tax.group.store');
            Route::post('/delete-tax-group', 'deleteTaxGroup')->name('tax.group.delete');
            Route::post('/get-tax-group-by-id', 'getTaxGroupById')->name('tax.group.get');
        });
    });

    Route::name('product.')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            //product setting
            Route::get('/product-settings', 'product_settings')->name('setting.product');
            Route::post('/product-settings-store', 'product_settings_store')->name('setting.product.store');
        });
    });
    Route::name('purchase.')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            //purchase setting
            Route::get('/purchase-settings', 'purchase_settings')->name('setting.purchase');
            Route::post('/purchase-settings-store', 'purchase_settings_store')->name('setting.purchase.store');
        });
    });

    Route::name('invoice.')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('/invoice-settings', 'invoiceSettings')->name('setting.index');
            Route::post('/invoice-settings-store', 'invoiceSettingUpdate')->name('setting.update');
        });
    });
    Route::name('pos_invoice.')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('/pos-invoice-settings', 'posInvoiceSettings')->name('setting.index');
            Route::post('/pos-invoice-settings-store', 'posInvoiceSettingUpdate')->name('setting.update');
        });
    });

    Route::group(['prefix' => 'apimenuszkt', 'middleware' => ['auth']], function () {
        Route::name('zktSetup.')->group(function () {
            Route::controller(ZktController::class)->group(function () {
                Route::get('zkt/add', 'create')->name('add');
                Route::post('zkt/store', 'store')->name('store');
                Route::get('zkt/list', 'index')->name('list');
                Route::get('zkt/edit/{id:id}', 'edit')->name('edit');
                Route::post('zkt/update/{id:id}', 'update')->name('update');
                Route::delete('zkt/destroy/{id:id}', 'destroy')->name('destroy');
            });
        });
    });

    Route::get('docexpired-setup', [DocExpiredSettingController::class, 'index'])->name('docexpired-setup.index');
    Route::post('docexpired-setup', [DocExpiredSettingController::class, 'store'])->name('docexpired-setup.store');

});

Route::group(['prefix' => 'web-setup', 'middleware' => 'auth'], function () {

    Route::name('view_setup.')->group(function () {
        Route::controller(ViewSetupController::class)->group(function () {
            Route::get('/setup-top-breaking', 'setupTopBreaking')->name('index');
            Route::post('top-breaking/store', 'store')->name('top_breaking_store');

            Route::get('/contact-page-setup', 'contactPageSetup')->name('contact_page_setup');
            Route::post('contact-page-setup/store', 'contactPageSetupStore')->name('contact_page_setup_store');

            Route::get('/home-page-settings', 'homePageSettings')->name('home_page_setup');
            Route::post('save_home_page_settings', 'homePageSettingsSave')->name('save_home_page_settings');
            Route::post('home-page-setup/store', 'homePageSettingsStore')->name('home_page_setup_store');
        });
    });

});

Route::get('/access-log', [SettingController::class, 'activityLog'])->name('activity_log');
Route::delete('/activity-log-destroy/{id:id}', [SettingController::class, 'activityLogDestroy'])->name('activity_log_destroy');
Route::delete('/multiple-activity-log-destroy', [SettingController::class, 'multipleDeleteActivityLog'])->name('multiple_delete_activity_log');

// Comments Routes
Route::get('/comments/comments_manage', [CommentsInfoController::class, 'index'])->name('comments.comments_manage');
Route::get('/comments/comments_manage/update/{com_id}', [CommentsInfoController::class, 'update'])->name('comments.update');
Route::delete('/comments/destroy/{comment:id}', [CommentsInfoController::class, 'destroy'])->name('comments.destroy');

// Subscription Routes
Route::get('/subscription/subscription_manage', [SubscriptionController::class, 'index'])->name('subscription.subscription_manage');
