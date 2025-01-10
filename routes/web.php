<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LicenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!


*/

Route::group(['middleware' => ['XssSanitization']], function () {

    Route::controller(App\Http\Controllers\Auth\MerchantRegisterController::class)->group(
        function () {
            Route::get('/merchant/register', 'index')->name('merchant.register.show');
            Route::post('/merchant/register', 'register')->name('merchant.register');
        }
    );

    Route::controller(App\Http\Controllers\Auth\AdminLoginController::class)->group(
        function () {
            Route::get('/admin/login', 'index')->name('admin.login.show');
            Route::post('/admin/login', 'login')->name('admin.login');
        }
    );

    Route::group(['middleware' => ['pverify']], function () {

        // ======== HomeController

        Route::controller(HomeController::class)->group(
            function () {

                Route::get('/', 'index')->name('home.page');
                Route::get('products/filter', 'products_filter')->name('products.filter');
                Route::get('/product/{slug}', 'auction_details')->name('auction.details');
                Route::get('/category/{slug}', 'auction_category')->name('auction.category');
                Route::get('/blogs', 'blogs')->name('blog.page');
                Route::get('blog/category/{slug}', 'blog_category')->name('blog.category');
                Route::get('blog/tag/{name}', 'blog_tag')->name('blog.tag');
                Route::get('/blog/{slug}', 'blog_details')->name('blog.details');
                Route::post('/blog/comment', 'blog_comment')->name('blog.comment');
                Route::post('/contact', 'contact_store')->name('contact.save');
                Route::post('/subscribe', 'newsletter_subscribe')->name('newsletter.subscribe');
                Route::post('/search', 'search')->name('main.search');
                Route::post('/shop_name_available_check', 'shop_name_available_check')->name('shop_name_available_check');
                Route::get('/shop/{slug}', 'shop_details')->name('shop.details');
                Route::post('/review/{id}/submit', 'review_submit')->name('review.submit');
               // Route::get('/payment/success', 'success')->name('payment.success');
               // Route::get('/payment/cancelled', 'cancelled')->name('payment.cancelled');
            }
        );

        Route::post('/changelanguage', [App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('language.change');

        // Get State and City
        //Route::post('/location/get/state', [App\Http\Controllers\LocationController::class, 'get_state'])->name('location.get.state');
        //Route::post('/location/get/city', [App\Http\Controllers\LocationController::class, 'get_city'])->name('location.get.city');
        Route::match(['get', 'post'],'/location/get/state', [App\Http\Controllers\LocationController::class, 'get_state'])->name('location.get.state');
        Route::match(['get', 'post'],'/location/get/city', [App\Http\Controllers\LocationController::class, 'get_city'])->name('location.get.city');
        Auth::routes();

    });
    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
});

/**
 * Verification Routes
 */
Route::group(['middleware' => ['auth', 'XssSanitization', 'pverify']], function () {
        Route::controller(App\Http\Controllers\Auth\VerificationController::class)->group(
            function () {
                Route::get('/email/verify', 'show')->name('verification.notice');
                Route::get('email/{token}/verify', 'verify_email')->name('verification.verify');
                Route::post('/email/resend', 'resend')->name('verification.resend');
            }
        );
    }
);

Route::group(['middleware' => ['auth', 'is_verified', 'customer', 'XssSanitization', 'pverify']],function () {
        Route::controller(App\Http\Controllers\HomeController::class)->group(
            function () {
                Route::get('/checkout', 'checkout')->name('live.auction.checkout');
                Route::post('/checkout', 'checkout_check')->name('live.auction.checkout.check');
                Route::get('/thank-you', 'thank_you')->name('thank_you');
            }
        );
        Route::post('/razorpay/success', [App\Http\Controllers\RazorpayController::class, 'success'])->name('razorpay.success');
        Route::get('/razorpay/error', [App\Http\Controllers\RazorpayController::class, 'error'])->name('razorpay.error');
    }
);

Route::group( ['prefix' => 'customer', 'middleware' => ['auth', 'is_verified', 'customer', 'XssSanitization', 'pverify']], function () {
        Route::controller(App\Http\Controllers\HomeController::class)->group(
            function () {
                Route::get('/dashboard', 'dashboard')->name('customer.dashboard');
                Route::get('/profile', 'customer_profile')->name('customer.profile');
                Route::patch('/profile/{id}/update', 'customer_update')->name('customer.profile.update');
                Route::get('/bid', 'customer_bid')->name('customer.bid');
                Route::get('/order/{id}/details', 'order_details')->name('customer.order.details');
                Route::get('/purchase', 'customer_purchase')->name('customer.purchase');
                Route::get('/deposit', 'customer_deposit')->name('customer.deposit');
                Route::get('/add/deposit', 'customer_deposit_new')->name('customer.deposit.new');
                Route::get('/transaction', 'customer_transaction')->name('customer.transaction');
            }
        );
        Route::controller(App\Http\Controllers\PaymentController::class)->group(function () {
            Route::post('/payment/method', 'customer_payment')->name('customer.payment.method');
        });

        Route::get('/payfast/success', [App\Http\Controllers\PayfastController::class, 'success'])->name('payfast.success');
        Route::match(['get', 'post'],'/payfast/notify', [App\Http\Controllers\PayfastController::class, 'notify'])->name('payfast.notify')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class, 'auth', 'pverify', 'is_verified', 'customer']);
        Route::get('/payfast/cancel', [App\Http\Controllers\PayfastController::class, 'cancel'])->name('payfast.cancel');

        Route::get('/paypal/{type}/success', [App\Http\Controllers\PaypalController::class, 'success'])->name('paypal.success');
        Route::get('/paypal/cancel', [App\Http\Controllers\PaypalController::class, 'error'])->name('paypal.error');
        Route::get('/stripe/confirm', [App\Http\Controllers\StripeController::class, 'confirm'])->name('stripe.confirm');
    }
);

Route::group( ['prefix' => 'dashboard', 'middleware' => ['auth', 'backend','pverify']],function () {
        Route::group(['middleware' => ['XssSanitization']], function () {
            Route::controller(App\Http\Controllers\AdminController::class)->group(function () {

                Route::get('/', 'index')->name('backend.dashboard');
                Route::get('/profile', 'profile')->name('backend.profile');
                Route::patch('/profile/{id}/update', 'profile_update')->name('backend.profile.update');
                Route::get('/shop', 'shop')->name('backend.shop');
                Route::post('/shop/update', 'shop_update')->name('backend.shop.update');
                Route::get('/transaction', 'transaction')->name('backend.transaction');
            });
        });

        Route::group( ['middleware' => ['admin']], function () {
                // Category
                Route::group( ['prefix' => 'category'],function () {
                        Route::controller(App\Http\Controllers\CategoryController::class)->group( function () {
                                Route::get('/', 'index')->name('category.list');
                                Route::post('/store', 'store')->name('category.store');
                                Route::get('/{id}/edit', 'edit')->name('category.edit');
                                Route::patch('/{id}/update', 'update')->name('category.update');
                                Route::delete('/{id}/destroy', 'destroy')->name('category.delete');
                                Route::post('/change/status', 'changeStatus')->name('category.change.status');
                            }
                        );
                    }
                );

                // Merchant
                Route::group(
                    ['prefix' => 'merchant'],
                    function () {
                        Route::controller(App\Http\Controllers\MerchantController::class)->group(
                            function () {

                                Route::get('/', 'index')->name('merchant.list');
                                Route::get('/create', 'create')->name('merchant.create');
                                Route::post('/store', 'store')->name('merchant.store');
                                Route::get('/{id}/edit', 'edit')->name('merchant.edit');
                                Route::patch('/{id}/update', 'update')->name('merchant.update');
                                Route::delete('/{id}/destroy', 'destroy')->name('merchant.delete');
                                // Route::patch('/{id}/approve',  'approve')->name('merchant.approve');
                                Route::post('/change/status', 'changeStatus')->name('merchant.change.status');
                                Route::get('/{id}/profile', 'show')->name('merchant.view');
                                Route::get('/login/{id}', 'login')->name('merchant.login');
                            }
                        );
                    }
                );
                // ================= menu Settings

                Route::group(
                    ['prefix' => 'menu'],
                    function () {

                        Route::controller(MenuController::class)->group(
                            function () {
                                Route::get('manage/{id?}', 'menu')->name('menu.list');
                                Route::get('add-menu', 'addToMenu')->name('add.menu');
                                Route::get('menu-item', 'storeMenuItem')->name('menu.item');
                                Route::get('menu-item-edit/{id}', 'editMenuItem')->name('menu.item.edit');
                                Route::post('menu-item-update', 'updateMenuItem')->name('menu.item.update');
                                Route::get('menu-item-delete/{id}', 'deleteMenuItem')->name('menu.item.delete');
                            }
                        );
                    }
                );

                // Email Template
                Route::group(
                    ['prefix' => 'email/template'],
                    function () {

                        Route::controller(App\Http\Controllers\EmailTemplateController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('email.template.list');
                                Route::get('/{id}/edit', 'edit')->name('email.template.edit');
                                Route::patch('/{id}/update', 'update')->name('email.template.update');
                            }
                        );
                    }
                );

                // Frontend Settings
                Route::group(
                    ['prefix' => 'frontend/settings'],
                    function () {
                        Route::controller(App\Http\Controllers\FrontendSettingController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('frontend.setting');
                                Route::post('/store', 'store')->name('frontend.settings.store');
                            }
                        );
                    }
                );

                // Backend Settings
                Route::group(
                    ['prefix' => 'backend/settings'],
                    function () {
                        Route::controller(App\Http\Controllers\BackendSettingController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('backend.setting');
                                Route::post('/store', 'store')->name('backend.settings.store');
                                Route::post('/testmail', 'sendTestMail')->name('backend.testmail');
                                Route::get('/cache-clear', 'cacheClear')->name('backend.cache-clear');
                            }
                        );
                    }
                );

                // Payment Methods
                Route::group(
                    ['prefix' => 'payment/methods'],
                    function () {
                        Route::controller(App\Http\Controllers\PaymentMethodController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('payment.methods');
                                Route::post('/edit', 'edit')->name('payment.methods.edit');
                                Route::post('/update', 'update')->name('payment.methods.update');
                                Route::post('/change/status', 'changeStatus')->name('payment.methods.status.change');
                            }
                        );
                    }
                );

                // Customer
                Route::group(
                    ['prefix' => 'customer'],
                    function () {

                        Route::controller(App\Http\Controllers\CustomerController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('customer.list');
                                Route::get('/create', 'create')->name('customer.create');
                                Route::post('/store', 'store')->name('customer.store');
                                Route::get('/{id}/edit', 'edit')->name('customer.edit');
                                Route::patch('/{id}/update', 'update')->name('customer.update');
                                Route::delete('/{id}/destroy', 'destroy')->name('customer.delete');
                                Route::post('/change/status', 'changeStatus')->name('customer.change.status');
                                Route::get('/{id}/profile', 'show')->name('customer.view');
                                Route::get('/login/{id}', 'login')->name('customer.login');
                            }
                        );
                    }
                );

                // ============== Language

                Route::group(
                    ['prefix' => 'languages'],
                    function () {

                        Route::controller(App\Http\Controllers\LanguageController::class)->group(
                            function () {

                                Route::get('', 'index')->name('languages.list');
                                Route::get('/create', 'create')->name('languages.create');
                                Route::post('/store', 'store')->name('languages.store');
                                Route::get('/{id}/edit', 'edit')->name('languages.edit');
                                Route::post('/{id}/update', 'update')->name('languages.update');
                                Route::delete('/{id}/destroy', 'destroy')->name('languages.delete');
                                Route::get('/change/status', 'changeStatus')->name('languages.change.status');
                                Route::get('/{id}', 'translations')->name('languages.translations');
                                Route::post('/{id}/key_value_store', 'key_value_store')->name('languages.key_value_store');
                            }
                        );
                    }
                );

                // ============== Contact

                Route::group(
                    ['prefix' => 'contacts'],
                    function () {

                        Route::controller(App\Http\Controllers\ContactController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('contact.list');
                                Route::get('/{id}/view', 'show')->name('contact.view');
                                Route::delete('/{id}/destroy', 'destroy')->name('contact.delete');
                            }
                        );
                    }
                );

                // Location

                Route::controller(App\Http\Controllers\LocationController::class)->group(
                    function () {

                        Route::get('/location', 'index')->name('location.list');
                        Route::post('/country/store', 'store')->name('country.store');
                        Route::get('country/{id}/edit', 'edit')->name('country.edit');
                        Route::patch('country/{id}/update', 'update')->name('country.update');
                        Route::delete('country/{id}/destroy', 'destroy')->name('country.delete');
                        Route::get('state/{id}/create', 'state_create')->name('state.create');
                        Route::post('state/{id}/store', 'state_store')->name('state.store');
                        Route::get('state/{id}/edit', 'state_edit')->name('state.edit');
                        Route::patch('state/{id}/update', 'state_update')->name('state.update');
                        Route::delete('state/{id}/destroy', 'state_destroy')->name('state.delete');
                        Route::get('city/{id}/create', 'city_create')->name('city.create');
                        Route::post('city/{id}/store', 'city_store')->name('city.store');
                        Route::get('city/{id}/edit', 'city_edit')->name('city.edit');
                        Route::patch('city/{id}/update', 'city_update')->name('city.update');
                        Route::delete('city/{id}/destroy', 'city_destroy')->name('city.delete');
                    }
                );

                // Deposits
                Route::get('/deposits', [App\Http\Controllers\DepositController::class, 'index'])->name('deposits.list');

                // ============ Pages

                Route::group(
                    ['prefix' => 'pages'],
                    function () {

                        Route::controller(App\Http\Controllers\PageController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('page.list');
                                Route::post('/store', 'store')->name('page.store');
                                Route::get('/{id}/edit', 'edit')->name('page.edit');
                                Route::patch('/{id}/update', 'update')->name('page.update');
                                Route::delete('/{id}/destroy', 'destroy')->name('page.delete');
                                Route::post('/change/status', 'changeStatus')->name('page.change.status');
                                Route::get('add-widget-page/{slug}', 'widgetAddedToPage')->name('pages.add.widget');
                                Route::post('widget-save-by-page', 'widgetUpdateByPage')->name('pages.widget.save');
                                Route::get('/widget-status/{id}', 'widgetStatusChange')->name('pages.widget.status.change');
                                Route::get('widget-delete-by-page/{id}', 'widgetDeleteByPage')->name('pages.widget.delete');
                                Route::get('/widget-sorted-by-page', 'widgetSortedByPage')->name('pages.widget.storted');
                                Route::post('/image-upload-file', 'imageUpload')->name('pages.image.upload');
                            }
                        );
                    }
                );

                // Blog
                Route::group(
                    ['prefix' => 'blogs'],
                    function () {

                        Route::controller(App\Http\Controllers\BlogCategoryController::class)->group(
                            function () {

                                Route::get('/category', 'index')->name('blog.category.list');
                                Route::post('/category/store', 'store')->name('blog.category.store');
                                Route::get('category/{id}/edit', 'edit')->name('blog.category.edit');
                                Route::patch('category/{id}/update', 'update')->name('blog.category.update');
                                Route::delete('category/{id}/destroy', 'destroy')->name('blog.category.delete');
                                Route::post('category/change/status', 'changeStatus')->name('blog.category.change.status');
                            }
                        );

                        Route::controller(App\Http\Controllers\BlogController::class)->group(
                            function () {
                                Route::get('/', 'index')->name('blog.list');
                                Route::get('/create', 'create')->name('blog.create');
                                Route::post('/store', 'store')->name('blog.store');
                                Route::get('/{id}/edit', 'edit')->name('blog.edit');
                                Route::patch('/{id}/update', 'update')->name('blog.update');
                                Route::delete('/{id}/destroy', 'destroy')->name('blog.delete');
                                Route::post('change/status', 'changeStatus')->name('blog.change.status');
                            }
                        );
                    }
                );
            }
        );

        // Products
        Route::group( ['prefix' => 'products'], function () {

                Route::controller(App\Http\Controllers\ProductController::class)->group(
                    function () {
                        Route::get('/', 'index')->name('products.list');
                        Route::get('/create', 'create')->name('products.create');
                        Route::post('/store', 'store')->name('products.store');
                        Route::get('/{id}/edit', 'edit')->name('products.edit');
                        Route::patch('/{id}/update', 'update')->name('products.update');
                        Route::delete('/{id}/destroy', 'destroy')->name('products.delete');
                        Route::get('/{id}/details', 'show')->name('products.details');
                        Route::post('/change/status', 'changeStatus')->name('products.change.status');
                        Route::patch('/{id}/approve', 'approve')->name('products.approve');
                        Route::post('/gallery/remove', 'gallery_remove')->name('products.gallery.remove');
                        Route::post('/specification/remove', 'specification_remove')->name('products.specification.remove');
                        Route::delete('/{id}/winner', 'winner')->name('bids.winner');
                        Route::post('/{id}/closed', 'closed')->name('bids.closed');
                        Route::get('/{id}/review', 'review')->name('products.review');
                        Route::post('/review/reply', 'review_reply')->name('products.review.reply');
                        Route::post('/review/change/status', 'changeReviewStatus')->name('products.change.review.status');
                    }
                );
            }
        );

        // Orders
        Route::group( ['prefix' => 'orders'],  function () {

                Route::controller(App\Http\Controllers\OrderController::class)->group(
                    function () {
                        Route::get('/', 'index')->name('order.list');
                        Route::get('/{id}/details', 'show')->name('order.details');
                        Route::get('/{id}/pdf/invoice', 'pdf_download_invoice')->name('pdf_download_invoice');
                        Route::post('/change/status', 'changeStatus')->name('order.change.status');
                    }
                );
            }
        );

        // Bidding
        Route::group(  ['prefix' => 'bidding'], function () {
                Route::controller(App\Http\Controllers\OrderController::class)->group(
                    function () {
                        Route::get('/', 'bidding')->name('bidding.list');
                        Route::get('/{id}/details', 'show')->name('bidding.details');
                    }
                );
            }
        );

        // ============ withdraws

        Route::group( ['prefix' => 'withdraw'],  function () {
                Route::controller(App\Http\Controllers\WithdrawController::class)->group(
                    function () {
                        Route::get('/', 'index')->name('withdraw.list');
                        Route::get('/request', 'withdraw_new')->name('withdraw.new');
                        Route::post('/request', 'withdraw_request')->name('withdraw.request');
                        Route::get('/details/{id}', 'details')->name('withdraw.details');
                        Route::patch('/status/{id}', 'status')->name('withdraw.status.change');
                    }
                );
            }
        );

        // Support Ticket
        Route::group( ['prefix' => 'supports'],  function () {

                Route::controller(App\Http\Controllers\SupportTicketController::class)->group(
                    function () {
                        Route::get('/', 'index')->name('support.list');
                        Route::get('/create', 'create')->name('support.create');
                        Route::post('/store', 'store')->name('support.store');
                        Route::get('/{id}/reply', 'edit')->name('support.edit');
                        Route::patch('/{id}/update', 'update')->name('support.update');
                        Route::delete('/{id}/destroy', 'destroy')->name('support.delete');
                        Route::get('close-ticket/{supportId}', 'closeTicket')->name('support.close.ticket');
                    }
                );
            }
        );

        // Winner
        Route::group( ['prefix' => 'winner'], function () {
                Route::get('/', [App\Http\Controllers\WinnerController::class, 'index'])->name('winner.list');
            }
        );
    });

    Route::group( ['prefix' => 'dashboard', 'middleware' => ['auth', 'backend']],  function () {

      Route::group(['prefix' => 'license'], function () {
        Route::get('/', [LicenseController::class, 'index'])->name('updateform.application');
        Route::get('/verify', [LicenseController::class, 'licenseVerifyForm'])->name('license.verify');
        Route::post('theme-update', [LicenseController::class, 'themeUpdate'])->name('update.theme');
        Route::post('license-verify-update', [LicenseController::class, 'verifyUpdate'])->name('license.verify.update');
        Route::post('license-purcahase-remove', [LicenseController::class, 'purcahaseRemove'])->name('license.purcahase.remove');
    });

});







Route::group(['middleware' => ['XssSanitization', 'pverify']], function () {
    Route::get('/{slug}', [App\Http\Controllers\HomeController::class, 'loadPagesContent'])->name('all_pages');
});
