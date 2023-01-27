<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'auth'], function () {
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register_action'])->name('register.action');
    Route::post('reset_password_action', [App\Http\Controllers\Auth\RegisterController::class, 'reset_password_action'])->name('resetpassword.action');
    Route::post('forgot_send', [App\Http\Controllers\Auth\RegisterController::class, 'forgot_send'])->name('forgot.send');
    Route::get('forgot', [App\Http\Controllers\Auth\RegisterController::class, 'forgot_the_password']);
    Route::get('activate', [App\Http\Controllers\Auth\RegisterController::class, 'activate']);
    Route::get('reset_password', [App\Http\Controllers\Auth\RegisterController::class, 'reset_password']);
    Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login_action'])->name('login.action');
    Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});



/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['namespace' => 'admin', 'prefix' => 'admin', 'middleware' => ['auth', 'user-access:admin']], function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index']);
    Route::get('home', [App\Http\Controllers\Admin\HomeController::class, 'index']);
    /*
    |--------------------------------------------------------------------------
    | Operator / Provider
    |--------------------------------------------------------------------------
    */
    Route::get('data/operator', [App\Http\Controllers\Admin\OperatorController::class, 'index']);
    Route::get('operator/json', [App\Http\Controllers\Admin\OperatorController::class, 'json'])->name('operator.list');
    Route::post('operator/save', [App\Http\Controllers\Admin\OperatorController::class, 'save'])->name('save.operator');
    Route::post('operator/update', [App\Http\Controllers\Admin\OperatorController::class, 'update'])->name('update.operator');
    Route::delete('delete_operator', [App\Http\Controllers\Admin\OperatorController::class, 'delete']);
    /*
    |--------------------------------------------------------------------------
    | Site Operator
    |--------------------------------------------------------------------------
    */
    Route::get('data/site', [App\Http\Controllers\Admin\SiteController::class, 'index']);
    Route::get('json', [App\Http\Controllers\Admin\SiteController::class, 'json'])->name('site_operator.list');
    Route::post('site/save', [App\Http\Controllers\Admin\SiteController::class, 'save'])->name('save.site_operator');
    Route::post('site/update', [App\Http\Controllers\Admin\SiteController::class, 'update'])->name('update.site_operator');
    Route::delete('delete_site', [App\Http\Controllers\Admin\SiteController::class, 'delete']);
    /*
    |--------------------------------------------------------------------------
    | Site Operator
    |--------------------------------------------------------------------------
    */
    Route::get('retribusi', [App\Http\Controllers\Admin\RetribusiController::class, 'index']);
    Route::get('retribusi/json', [App\Http\Controllers\Admin\RetribusiController::class, 'json'])->name('retribusi.list');
    Route::post('retribusi/save', [App\Http\Controllers\Admin\RetribusiController::class, 'save'])->name('save.retribusi');
    Route::post('retribusi/update', [App\Http\Controllers\Admin\RetribusiController::class, 'update'])->name('update.retribusi');
    Route::delete('delete_retribusi', [App\Http\Controllers\Admin\RetribusiController::class, 'delete']);
    /*
    |--------------------------------------------------------------------------
    | Settng Website
    |--------------------------------------------------------------------------
    */
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index']);
    Route::post('save_settings', [App\Http\Controllers\Admin\SettingController::class, 'save']);
});

