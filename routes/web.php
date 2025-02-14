<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\AuthAdminVerifyController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\SubCategoryAdminController;
use App\Http\Controllers\Admin\TagAdminController;
use App\Http\Controllers\Merchant\AuthMerchantController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\AuthUserVerifyController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\WebPage\WebController;
use Illuminate\Support\Facades\Route;

Route::name('web.')->group(function () {
    Route::get('/', [WebController::class, 'index'])->name('index');
    Route::get('shop/{category}', [WebController::class, 'category'])->name('shop.index');
    Route::get('shop/{category}/{product}', [WebController::class, 'product'])->name('shop.product');
});

Route::get('login', [AuthUserController::class, 'login'])->name('login');
Route::post('login', [AuthUserController::class, 'loginAuth'])->name('auth.login');
Route::get('register', [AuthUserController::class, 'register'])->name('register');
Route::post('register', [AuthUserController::class, 'registerAuth'])->name('auth.register');
Route::get('forgot-password', [AuthUserController::class, 'forgetPassword'])->name('password.request');
Route::post('forgot-password', [AuthUserController::class, 'forgetPasswordAuth'])->name('auth.password.request');
Route::get('reset-password/{token}', [AuthUserController::class, 'resetPassword'])->name('password.reset');
Route::post('reset-password', [AuthUserController::class, 'resetPasswordAuth'])->name('auth.password.reset');
Route::post('logout', [AuthUserController::class, 'destroy'])->name('auth.destroy');

Route::middleware(['auth:web'])->group(function () {
    Route::get('email/verify', [AuthUserVerifyController::class, 'notice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [AuthUserVerifyController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('email/resend', [AuthUserVerifyController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.resend');
});

Route::middleware(['auth:web', 'apps-verified:web'])->group(function (){
    Route::get('dashboard', [DashboardUserController::class, 'index'])->name('dashboard');
});


// ======= //
Route::get('merchant', [AuthMerchantController::class, 'redirect'])->name('merchant.redirect');
Route::prefix('merchant')->name('merchant.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', [AuthMerchantController::class, 'login'])->name('login');
        Route::post('login', [AuthMerchantController::class, 'loginAuth'])->name('auth.login');
        Route::get('register', [AuthMerchantController::class, 'register'])->name('register');
        Route::post('register', [AuthMerchantController::class, 'registerAuth'])->name('auth.register');
        Route::get('forgot-password', [AuthMerchantController::class, 'forgetPassword'])->name('password.request');
        Route::post('forgot-password', [AuthMerchantController::class, 'forgetPasswordAuth'])->name('auth.password.request');
        Route::get('reset-password/{token}', [AuthMerchantController::class, 'resetPassword'])->name('password.reset');
        Route::post('reset-password', [AuthMerchantController::class, 'resetPasswordAuth'])->name('auth.password.reset');
        Route::post('logout', [AuthMerchantController::class, 'destroy'])->name('auth.destroy');
    });
    Route::middleware(['auth:merchant'])->group(function () {

    });
    Route::middleware(['auth:merchant', 'apps-verified:merchant'])->group(function (){

    });
});


// ======= //
Route::get('admin', [AuthAdminController::class, 'redirect'])->name('admin.redirect');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function (){
        Route::get('login', [AuthAdminController::class, 'login'])->name('login');
        Route::post('login', [AuthAdminController::class, 'loginAuth'])->name('auth.login');
        Route::post('logout', [AuthAdminController::class, 'destroy'])->name('auth.destroy');
    });
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('email/verify', [AuthAdminVerifyController::class, 'notice'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [AuthAdminVerifyController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
        Route::post('email/resend', [AuthAdminVerifyController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.resend');
    });
    Route::middleware(['auth:admin', 'apps-verified:admin'])->group(function (){
        Route::get('dashboard', [DashboardAdminController::class, 'dashboard'])->name('dashboard');
        Route::prefix('shop')->name('shop.')->group(function () {
            Route::resources([
                'categories' => CategoryAdminController::class,
                'sub-categories' => SubCategoryAdminController::class,
                'tags' => TagAdminController::class,
                'products' => ProductAdminController::class
            ]);
        });
    });
});
