<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\AuthAdminVerifyController;
use App\Http\Controllers\Admin\CarouselSliderAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\CourierAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\MenuAdminController;
use App\Http\Controllers\Admin\MerchantAdminController;
use App\Http\Controllers\Admin\NewsFeedCommentAdminController;
use App\Http\Controllers\Admin\NewsFeedLikeAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\PostCategoryAdminController;
use App\Http\Controllers\Admin\PostTagAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\ShipmentAdminController;
use App\Http\Controllers\Admin\ShipmentGeneralAdminController;
use App\Http\Controllers\Admin\ShippingProviderAdminController;
use App\Http\Controllers\Admin\ShopAdminController;
use App\Http\Controllers\Admin\SubCategoryAdminController;
use App\Http\Controllers\Admin\TagAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\WalletWithdrawRequestAdminController;
use App\Http\Controllers\Admin\WalletWithdrawRequestApprovalAdminController;
use App\Http\Controllers\Admin\WidgetAdminController;
use App\Http\Controllers\Merchant\AuthMerchantController;
use App\Http\Controllers\Merchant\AuthMerchantVerifyController;
use App\Http\Controllers\Merchant\CourierMerchantController;
use App\Http\Controllers\Merchant\DashboardMerchantController;
use App\Http\Controllers\Merchant\DashboardMerchantRedirectController;
use App\Http\Controllers\Merchant\NewsFeedCommentMerchantController;
use App\Http\Controllers\Merchant\NewsFeedLikeMerchantController;
use App\Http\Controllers\Merchant\NewsFeedMerchantController;
use App\Http\Controllers\Merchant\ProductMerchantController;
use App\Http\Controllers\Merchant\SpecialOfferMerchantController;
use App\Http\Controllers\Merchant\WalletMerchantController;
use App\Http\Controllers\Merchant\WalletWithdrawRequestMerchantController;
use App\Http\Controllers\Services\AppsPaymentController;
use App\Http\Controllers\User\AddressUserController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\AuthUserVerifyController;
use App\Http\Controllers\User\CompareUserController;
use App\Http\Controllers\User\DashboardRedirectController;
use App\Http\Controllers\User\NewsFeedCommentUserController;
use App\Http\Controllers\User\NewsFeedLikeUserController;
use App\Http\Controllers\User\NewsFeedUserController;
use App\Http\Controllers\User\ProfileUserController;
use App\Http\Controllers\User\PurchaseUserController;
use App\Http\Controllers\User\ReviewUserController;
use App\Http\Controllers\User\WishlistUserController;
use App\Http\Controllers\WebPage\WebController;
use Illuminate\Support\Facades\Route;

Route::name('web.')->group(function () {
    Route::get('about-us', [WebController::class, 'about'])->name('about');
    Route::get('privacy-policy', [WebController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('terms-and-conditions', [WebController::class, 'termsConditions'])->name('terms-and-conditions');
    Route::middleware('auth:web')->group(function () {
        Route::get('/', [WebController::class, 'index'])->name('index');
        Route::get('shop/{menu}', [WebController::class, 'shopIndex'])->name('shop.index');
        Route::get('shop/{menu}/{category}', [WebController::class, 'shopCategory'])->name('shop.category');
        Route::get('shop/{menu}/{category}/{product}', [WebController::class, 'shopProduct'])->name('shop.product');
        Route::get('sort/{menu}/sort', [WebController::class, 'shopIndexSort'])->name('shop.menu.sort');
        Route::get('sort/{menu}/{category}/sort', [WebController::class, 'shopCategorySort'])->name('shop.category.sort');
        Route::get('quick-view/{product}', [WebController::class, 'quickview'])->name('shop.quickview');
    });

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [WebController::class, 'blog'])->name('index');
        Route::get('{category}', [WebController::class, 'blogCategory'])->name('category');
        Route::get('{category}/{post}', [WebController::class, 'blogPost'])->name('post');
    });

    Route::get('sitemap.xml', [WebController::class, 'sitemap'])->name('sitemap');
});

Route::middleware('guest:web')->group(function () {
    Route::get('login', [AuthUserController::class, 'login'])->name('login');
    Route::post('login', [AuthUserController::class, 'loginAuth'])->name('auth.login');
    Route::get('register', [AuthUserController::class, 'register'])->name('register');
    Route::post('register', [AuthUserController::class, 'registerAuth'])->name('auth.register');
    Route::get('forgot-password', [AuthUserController::class, 'forgetPassword'])->name('password.request');
    Route::post('forgot-password', [AuthUserController::class, 'forgetPasswordAuth'])->name('auth.password.request');
    Route::get('reset-password/{token}', [AuthUserController::class, 'resetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthUserController::class, 'resetPasswordAuth'])->name('auth.password.reset');
});
Route::post('logout', [AuthUserController::class, 'destroy'])->name('auth.destroy');
Route::view('force-login', 'apps.auth.force-login')->name('force-login');
Route::resource('compare', CompareUserController::class)->except(['create', 'show', 'edit', 'update']);

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/countries', [AddressUserController::class, 'getCountries']);
    Route::get('/states', [AddressUserController::class, 'getStates']);
    Route::get('/cities', [AddressUserController::class, 'getCities']);
    Route::get('/streets', [AddressUserController::class, 'getStreets']);
    Route::get('/postcodes', [AddressUserController::class, 'getPostcodes']);
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('email/verify', [AuthUserVerifyController::class, 'notice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [AuthUserVerifyController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('email/resend', [AuthUserVerifyController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.resend');
    Route::get('under-review', [AuthUserVerifyController::class, 'underReview'])->name('under.review')->middleware('its_approved');
});

Route::prefix('purchase')->name('purchase.')->group(function () {
    Route::post('add-to-cart', [PurchaseUserController::class, 'updateOrCreateCart'])->name('add-to-cart');
    Route::post('remove-from-cart/{id}', [PurchaseUserController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::post('remove-option-group/{productId}/{groupKey}', [PurchaseUserController::class, 'removeOptionGroup'])->name('remove-option-group');
    Route::get('clear-cart', [PurchaseUserController::class, 'clearCart'])->name('clear-cart');
    Route::get('options/{option}', [PurchaseUserController::class, 'options'])->name('options');
});

Route::middleware(['custom.auth:web', 'apps-verified:web'])->group(function (){
    Route::get('dashboard', [DashboardRedirectController::class, 'index'])->name('dashboard')->middleware('approved');
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('profile-edit', [ProfileUserController::class, 'profileEdit'])->name('profile.edit');
        Route::post('profile-update', [ProfileUserController::class, 'profileUpdate'])->name('profile.update');
        Route::get('password-edit', [ProfileUserController::class, 'passwordEdit'])->name('password.edit');
        Route::post('password-update', [ProfileUserController::class, 'passwordUpdate'])->name('password.update');
        Route::resource('saved-address', AddressUserController::class);
        Route::resource('news-feed', NewsFeedUserController::class)->except(['index', 'create', 'show']);
        Route::resource('news-feed-like', NewsFeedLikeUserController::class)->except(['index', 'create', 'show', 'edit', 'update', 'destroy']);
        Route::resource('news-feed-comment', NewsFeedCommentUserController::class)->except(['index', 'create', 'show', 'edit']);
        Route::resource('wishlist', WishlistUserController::class);
        Route::post('wishlist/refresh', [WishlistUserController::class, 'refresh'])->name('wishlist.refresh');
    });

    Route::get('address', [ProfileUserController::class, 'addressBook'])->name('address');

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('products/{product}/reviews/create', [ReviewUserController::class, 'create'])->name('create');
        Route::post('products/{product}/reviews', [ReviewUserController::class, 'store'])->name('store');
        Route::post('{review}/reply', [ReviewUserController::class, 'storeReply'])->name('reply');
    });
    Route::prefix('purchase')->name('purchase.')->middleware('approved')->group(function () {
        Route::get('cart', [PurchaseUserController::class, 'viewCart'])->name('cart');
        Route::post('cart-qty-update', [PurchaseUserController::class, 'updateCartQuantity'])->name('cart.quantity.update');
        Route::get('checkout', [PurchaseUserController::class, 'checkout'])->name('checkout');
        Route::post('checkoutPost', [PurchaseUserController::class, 'checkoutPost'])->name('checkout-post');
        Route::get('payment-redirect', [AppsPaymentController::class, 'redirectUrl'])->name('payment.redirect.url');
    });
});
Route::prefix('purchase')->name('purchase.')->group(function () {
    Route::post('payment-webhook', [AppsPaymentController::class, 'webhookUrl'])->name('payment.webhook.url');
});

// ======= //
Route::get('merchant', [AuthMerchantController::class, 'redirect'])->name('merchant.redirect');
Route::prefix('merchant')->name('merchant.')->group(function () {
    Route::middleware('guest:merchant')->group(function () {
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
        Route::get('email/verify', [AuthMerchantVerifyController::class, 'notice'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [AuthMerchantVerifyController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
        Route::post('email/resend', [AuthMerchantVerifyController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.resend');
        Route::get('under-review', [AuthMerchantVerifyController::class, 'underReview'])->name('under.review')->middleware('its_approved');
    });
    Route::middleware(['custom.auth:merchant', 'apps-verified:merchant', 'approved'])->group(function (){
        Route::get('dashboard', [DashboardMerchantRedirectController::class, 'index'])->name('dashboard');
        Route::put('profile-update', [DashboardMerchantController::class, 'profileUpdate'])->name('profile.update');
        Route::put('address-update', [DashboardMerchantController::class, 'addressUpdate'])->name('address.update');
        Route::put('password-update', [DashboardMerchantController::class, 'passwordUpdate'])->name('password.update');
        Route::get('categories/{category}/subcategories', [ShopAdminController::class, 'getSubcategories'])->name('categories.subcategories');
        Route::resource('products', ProductMerchantController::class);
        Route::resource('news-feed', NewsFeedMerchantController::class)->except(['index', 'create', 'show']);
        Route::resource('news-feed-like', NewsFeedLikeMerchantController::class)->except(['index', 'create', 'show', 'edit', 'update', 'destroy']);
        Route::resource('news-feed-comment', NewsFeedCommentMerchantController::class)->except(['index', 'create', 'show', 'edit']);
        Route::resource('wallet-request', WalletWithdrawRequestMerchantController::class);

        Route::post('couriers/fetch', [CourierMerchantController::class, 'fetchFromProvider'])->name('couriers.fetch');
        Route::post('couriers/submit-order', [CourierMerchantController::class, 'submitOrder'])->name('couriers.submit-order');
    });
});


// ======= //
Route::get('admin', [AuthAdminController::class, 'redirect'])->name('admin.redirect');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function (){
        Route::get('login', [AuthAdminController::class, 'login'])->name('login');
        Route::post('login', [AuthAdminController::class, 'loginAuth'])->name('auth.login');
        Route::get('register', [AuthAdminController::class, 'register'])->name('register');
        Route::post('register', [AuthAdminController::class, 'registerAuth'])->name('auth.register');
        Route::get('forgot-password', [AuthAdminController::class, 'forgetPassword'])->name('password.request');
        Route::post('forgot-password', [AuthAdminController::class, 'forgetPasswordAuth'])->name('auth.password.request');
        Route::get('reset-password/{token}', [AuthAdminController::class, 'resetPassword'])->name('password.reset');
        Route::post('reset-password', [AuthAdminController::class, 'resetPasswordAuth'])->name('auth.password.reset');
        Route::post('logout', [AuthAdminController::class, 'destroy'])->name('auth.destroy');
    });
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('email/verify', [AuthAdminVerifyController::class, 'notice'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [AuthAdminVerifyController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
        Route::post('email/resend', [AuthAdminVerifyController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.resend');
    });
    Route::middleware(['custom.auth:admin', 'apps-verified:admin'])->group(function (){
        Route::get('dashboard', [DashboardAdminController::class, 'dashboard'])->name('dashboard');
        Route::prefix('registered-user')->name('registered-user.')->group(function () {
            Route::resources([
                'users' => UserAdminController::class,
                'merchants' => MerchantAdminController::class,
            ]);
        });
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::resources([
                'categories' => PostCategoryAdminController::class,
                'tags' => PostTagAdminController::class,
                'posts' => PostAdminController::class,
            ]);
        });
        Route::prefix('shipping-service')->name('shipping-service.')->group(function () {
            Route::resources([
                'shipping-provider' => ShippingProviderAdminController::class,
                'courier' => CourierAdminController::class,
                'shipment' => ShipmentAdminController::class,
            ]);
            Route::post('generate-po', [ShipmentGeneralAdminController::class, 'generatePo'])->name('generate.po');
            Route::post('generate-receipt', [ShipmentGeneralAdminController::class, 'generateReceipt'])->name('generate.receipt');
        });
        Route::prefix('shop')->name('shop.')->group(function () {
            Route::get('categories/{category}/subcategories', [ShopAdminController::class, 'getSubcategories'])->name('categories.subcategories');
            Route::resources([
                'categories' => CategoryAdminController::class,
                'sub-categories' => SubCategoryAdminController::class,
                'tags' => TagAdminController::class,
                'products' => ProductAdminController::class,
                'special-offer' => SpecialOfferMerchantController::class,
                'reviews' => ReviewAdminController::class
            ]);
        });
        Route::resource('wallet-request', WalletWithdrawRequestAdminController::class);
        Route::patch('wallet-request/{id}/approve', [WalletWithdrawRequestApprovalAdminController::class, 'approve'])->name('wallet.withdraw.approval');
        Route::resource('order', OrderAdminController::class);
        Route::resource('menus', MenuAdminController::class);
        Route::resource('carousel-slider', CarouselSliderAdminController::class);
        Route::resource('news-feed', NewsFeedUserController::class)->except(['index', 'create', 'show']);
        Route::resource('news-feed-like', NewsFeedLikeAdminController::class)->except(['index', 'create', 'show', 'edit', 'update', 'destroy']);
        Route::resource('news-feed-comment', NewsFeedCommentAdminController::class)->except(['index', 'create', 'show', 'edit']);
        Route::resource('widget', WidgetAdminController::class);
    });
});
