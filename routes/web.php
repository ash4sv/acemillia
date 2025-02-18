<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\AuthAdminVerifyController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\MerchantAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ShopAdminController;
use App\Http\Controllers\Admin\SubCategoryAdminController;
use App\Http\Controllers\Admin\TagAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Merchant\AuthMerchantController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\AuthUserVerifyController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\User\ProfileUserController;
use App\Http\Controllers\User\PurchaseUserController;
use App\Http\Controllers\WebPage\WebController;
use Illuminate\Support\Facades\Route;

Route::name('web.')->group(function () {
    Route::get('/', [WebController::class, 'index'])->name('index');
    Route::get('shop/{category}', [WebController::class, 'category'])->name('shop.index');
    Route::get('shop/{category}/{product}', [WebController::class, 'product'])->name('shop.product');
    Route::get('quick-view/{product}', [WebController::class, 'quickview'])->name('shop.quickview');
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

Route::prefix('purchase')->name('purchase.')->group(function () {
    Route::post('add-to-cart', [PurchaseUserController::class, 'updateOrCreateCart'])->name('add-to-cart');
    Route::post('remove-from-cart/{id}', [PurchaseUserController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::get('clear-cart', [PurchaseUserController::class, 'clearCart'])->name('clear-cart');
    Route::get('options/{option}', [PurchaseUserController::class, 'options'])->name('options');
});

Route::middleware(['auth:web', 'apps-verified:web'])->group(function (){
    Route::get('dashboard', [DashboardUserController::class, 'index'])->name('dashboard');
    Route::get('profile-edit', [ProfileUserController::class, 'profileEdit'])->name('profile.edit');
    Route::post('profile-update', [ProfileUserController::class, 'profileUpdate'])->name('profile.update');
    Route::get('password-edit', [ProfileUserController::class, 'passwordEdit'])->name('password.edit');

    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::get('cart', [PurchaseUserController::class, 'viewCart'])->name('cart');
        Route::get('checkout', [PurchaseUserController::class, 'checkout'])->name('checkout');
        Route::post('checkoutPost', [PurchaseUserController::class, 'checkoutPost'])->name('checkout-post');
    });
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
        Route::prefix('registered-user')->name('registered-user.')->group(function () {
            Route::resources([
                'users' => UserAdminController::class,
                'merchants' => MerchantAdminController::class,
            ]);
        });
        Route::prefix('shop')->name('shop.')->group(function () {
            Route::get('categories/{category}/subcategories', [ShopAdminController::class, 'getSubcategories'])->name('categories.subcategories');
            Route::resources([
                'categories' => CategoryAdminController::class,
                'sub-categories' => SubCategoryAdminController::class,
                'tags' => TagAdminController::class,
                'products' => ProductAdminController::class
            ]);
        });
    });
});
