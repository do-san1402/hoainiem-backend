<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Http\Controllers\UserTypeController;
use Modules\UserManagement\Http\Controllers\RoleManagementController;
use Modules\UserManagement\Http\Controllers\UserManagementController;
use Modules\UserManagement\Http\Controllers\PasswordSettingController;

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

Route::group(['middleware' => 'auth'], function () {

    Route::resource('user-types' , UserTypeController::class);
    Route::resource('password-settings' , PasswordSettingController::class);

    //for select2 search
    Route::get('get-user-by-ajax',  [UserManagementController::class, 'getUserByAjax'])->name('user.search');

    // User Profile Update
    Route::post('/user-profile-update', [UserManagementController::class, 'update'])->name('profile.update');
    Route::post('/user-profile-image-update/{id:id}', [UserManagementController::class, 'profilePictureUpdate'])->name('profile_image.update');
    Route::post('/user-profile-cover-image-update/{id:id}', [UserManagementController::class, 'coverImageUpdate'])->name('profile_cover_image.update');
    Route::post('/user-change-password', [UserManagementController::class, 'updatePassword'])->name('profile.changePassword');

    Route::name('role.')->group(function () {
        Route::controller(RoleManagementController::class)->group(function () {
            Route::get('role-list', 'roleList')->name('list');
            Route::get('role-add', 'roleCreate')->name('add');
            Route::get('role-view', 'roleView')->name('view');
            Route::post('role-store', 'roleStore')->name('store');
            Route::get('role-edit/{role}', 'roleEdit')->name('edit');
            Route::post('role-update', 'roleUpdate')->name('update');
            Route::post('role-delete', 'roleDelete')->name('delete');

            //menu
            Route::get('menu-list', 'menuList')->name('menu.list');
            Route::get('menu-add', 'menuCreate')->name('menu.add');
            Route::post('menu-store', 'menuStore')->name('menu.store');
            Route::get('menu-edit/{id}', 'menuEdit')->name('menu.edit');
            Route::post('menu-update/{menupermission:uuid}', 'menuUpdate')->name('menu.update');
            Route::post('menu-delete', 'menuDelete')->name('menu.delete');

            //permission
            Route::get('permission-list', 'permissionList')->name('permission.list');
            Route::get('permission-add', 'permissionCreate')->name('permission.add');
            Route::post('permission-store', 'permissionStore')->name('permission.store');
            Route::get('permission-edit/{permission}', 'permissionEdit')->name('permission.edit');
            Route::post('permission-update/{permission:uuid}', 'permissionUpdate')->name('permission.update');
            Route::post('permission-delete', 'permissionDelete')->name('permission.delete');

        });

        Route::controller(UserManagementController::class)->group(function () {
            //user
            Route::get('user-list', 'userList')->name('user.list');
            Route::get('user-add', 'userCreate')->name('user.add');
            Route::post('user-store', 'userStore')->name('user.store');
            Route::get('user-edit/{user}', 'userEdit')->name('user.edit');
            Route::post('user-update/{user}', 'userUpdate')->name('user.update');
            Route::post('user-delete', 'userDelete')->name('user.delete');
            
        });
    });
});
