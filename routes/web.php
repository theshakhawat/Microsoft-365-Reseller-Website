<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Payment\MoneybagPaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $plans = App\Models\PricingPlan::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $howItWorks = App\Models\HowItWork::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $keyFeatures = App\Models\KeyFeature::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $productivityApps = App\Models\IncludedApp::where('category', 'productivity')->where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $securityApps = App\Models\IncludedApp::where('category', 'security')->where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $trustedBrands = App\Models\TrustedBrand::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $moreBenefits = App\Models\MoreBenefit::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $aiFeatures = App\Models\AiFeature::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $faqs = App\Models\Faq::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    return view('welcome', compact('plans', 'howItWorks', 'keyFeatures', 'productivityApps', 'securityApps', 'trustedBrands', 'moreBenefits', 'aiFeatures', 'faqs'));
})->name('home');

// Public Contact Form Submission Route
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])->name('password.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Common Routes
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes (Role: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/clear-cache', [DashboardController::class, 'clearCache'])->name('clear-cache');

    // Dedicated Admin Profile Update Routes
    Route::get('/profile', [App\Http\Controllers\AdminProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\AdminProfileController::class, 'updateProfile'])->name('profile.update');

    // Dedicated Admin Change Password Routes
    Route::get('/change-password', [App\Http\Controllers\AdminProfileController::class, 'changePassword'])->name('password');
    Route::post('/change-password', [App\Http\Controllers\AdminProfileController::class, 'updatePassword'])->name('password.update');

    // Key Features Management CRUD Routes
    Route::get('/key-features', [App\Http\Controllers\AdminKeyFeatureController::class, 'index'])->name('key-features.index');
    Route::get('/key-features/create', [App\Http\Controllers\AdminKeyFeatureController::class, 'create'])->name('key-features.create');
    Route::post('/key-features', [App\Http\Controllers\AdminKeyFeatureController::class, 'store'])->name('key-features.store');
    Route::get('/key-features/{keyFeature}/edit', [App\Http\Controllers\AdminKeyFeatureController::class, 'edit'])->name('key-features.edit');
    Route::put('/key-features/{keyFeature}', [App\Http\Controllers\AdminKeyFeatureController::class, 'update'])->name('key-features.update');
    Route::post('/key-features/{keyFeature}/toggle', [App\Http\Controllers\AdminKeyFeatureController::class, 'toggleStatus'])->name('key-features.toggle');
    Route::delete('/key-features/{keyFeature}', [App\Http\Controllers\AdminKeyFeatureController::class, 'destroy'])->name('key-features.destroy');

    // Included Apps ("What's Included") Management CRUD Routes
    Route::get('/included-apps', [App\Http\Controllers\AdminIncludedAppController::class, 'index'])->name('included-apps.index');
    Route::get('/included-apps/create', [App\Http\Controllers\AdminIncludedAppController::class, 'create'])->name('included-apps.create');
    Route::post('/included-apps', [App\Http\Controllers\AdminIncludedAppController::class, 'store'])->name('included-apps.store');
    Route::get('/included-apps/{includedApp}/edit', [App\Http\Controllers\AdminIncludedAppController::class, 'edit'])->name('included-apps.edit');
    Route::put('/included-apps/{includedApp}', [App\Http\Controllers\AdminIncludedAppController::class, 'update'])->name('included-apps.update');
    Route::post('/included-apps/{includedApp}/toggle', [App\Http\Controllers\AdminIncludedAppController::class, 'toggleStatus'])->name('included-apps.toggle');
    Route::delete('/included-apps/{includedApp}', [App\Http\Controllers\AdminIncludedAppController::class, 'destroy'])->name('included-apps.destroy');

    // Trusted Brands ("Trusted by millions") Management CRUD Routes
    Route::get('/trusted-brands', [App\Http\Controllers\AdminTrustedBrandController::class, 'index'])->name('trusted-brands.index');
    Route::get('/trusted-brands/create', [App\Http\Controllers\AdminTrustedBrandController::class, 'create'])->name('trusted-brands.create');
    Route::post('/trusted-brands', [App\Http\Controllers\AdminTrustedBrandController::class, 'store'])->name('trusted-brands.store');
    Route::get('/trusted-brands/{trustedBrand}/edit', [App\Http\Controllers\AdminTrustedBrandController::class, 'edit'])->name('trusted-brands.edit');
    Route::put('/trusted-brands/{trustedBrand}', [App\Http\Controllers\AdminTrustedBrandController::class, 'update'])->name('trusted-brands.update');
    Route::post('/trusted-brands/{trustedBrand}/toggle', [App\Http\Controllers\AdminTrustedBrandController::class, 'toggleStatus'])->name('trusted-brands.toggle');
    Route::delete('/trusted-brands/{trustedBrand}', [App\Http\Controllers\AdminTrustedBrandController::class, 'destroy'])->name('trusted-brands.destroy');

    // More Benefits ("Explore even more benefits") Management CRUD Routes
    Route::get('/more-benefits', [App\Http\Controllers\AdminMoreBenefitController::class, 'index'])->name('more-benefits.index');
    Route::get('/more-benefits/create', [App\Http\Controllers\AdminMoreBenefitController::class, 'create'])->name('more-benefits.create');
    Route::post('/more-benefits', [App\Http\Controllers\AdminMoreBenefitController::class, 'store'])->name('more-benefits.store');
    Route::get('/more-benefits/{moreBenefit}/edit', [App\Http\Controllers\AdminMoreBenefitController::class, 'edit'])->name('more-benefits.edit');
    Route::put('/more-benefits/{moreBenefit}', [App\Http\Controllers\AdminMoreBenefitController::class, 'update'])->name('more-benefits.update');
    Route::post('/more-benefits/{moreBenefit}/toggle', [App\Http\Controllers\AdminMoreBenefitController::class, 'toggleStatus'])->name('more-benefits.toggle');
    Route::delete('/more-benefits/{moreBenefit}', [App\Http\Controllers\AdminMoreBenefitController::class, 'destroy'])->name('more-benefits.destroy');

    // AI Features ("Intelligent Capabilities" Slider) Management CRUD Routes
    Route::get('/ai-features', [App\Http\Controllers\AdminAiFeatureController::class, 'index'])->name('ai-features.index');
    Route::get('/ai-features/create', [App\Http\Controllers\AdminAiFeatureController::class, 'create'])->name('ai-features.create');
    Route::post('/ai-features', [App\Http\Controllers\AdminAiFeatureController::class, 'store'])->name('ai-features.store');
    Route::get('/ai-features/{aiFeature}/edit', [App\Http\Controllers\AdminAiFeatureController::class, 'edit'])->name('ai-features.edit');
    Route::put('/ai-features/{aiFeature}', [App\Http\Controllers\AdminAiFeatureController::class, 'update'])->name('ai-features.update');
    Route::post('/ai-features/{aiFeature}/toggle', [App\Http\Controllers\AdminAiFeatureController::class, 'toggleStatus'])->name('ai-features.toggle');
    Route::delete('/ai-features/{aiFeature}', [App\Http\Controllers\AdminAiFeatureController::class, 'destroy'])->name('ai-features.destroy');

    // FAQ ("Did you know?") Management CRUD Routes
    Route::get('/faqs', [App\Http\Controllers\AdminFaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [App\Http\Controllers\AdminFaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [App\Http\Controllers\AdminFaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{faq}/edit', [App\Http\Controllers\AdminFaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{faq}', [App\Http\Controllers\AdminFaqController::class, 'update'])->name('faqs.update');
    Route::post('/faqs/{faq}/toggle', [App\Http\Controllers\AdminFaqController::class, 'toggleStatus'])->name('faqs.toggle');
    Route::delete('/faqs/{faq}', [App\Http\Controllers\AdminFaqController::class, 'destroy'])->name('faqs.destroy');

    // Contact Messages & Inquiries Management CRUD Routes
    Route::get('/contact-messages', [App\Http\Controllers\AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::post('/contact-messages/settings', [App\Http\Controllers\AdminContactMessageController::class, 'updateSettings'])->name('contact-messages.update-settings');
    Route::post('/contact-messages/mark-all-read', [App\Http\Controllers\AdminContactMessageController::class, 'markAllAsRead'])->name('contact-messages.mark-all-read');
    Route::get('/contact-messages/{contactMessage}', [App\Http\Controllers\AdminContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::post('/contact-messages/{contactMessage}/toggle-read', [App\Http\Controllers\AdminContactMessageController::class, 'toggleRead'])->name('contact-messages.toggle-read');
    Route::delete('/contact-messages/{contactMessage}', [App\Http\Controllers\AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    // Pricing Plans Management CRUD Routes
    Route::get('/plans', [App\Http\Controllers\AdminPricingPlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [App\Http\Controllers\AdminPricingPlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [App\Http\Controllers\AdminPricingPlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [App\Http\Controllers\AdminPricingPlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [App\Http\Controllers\AdminPricingPlanController::class, 'update'])->name('plans.update');
    Route::post('/plans/{plan}/toggle', [App\Http\Controllers\AdminPricingPlanController::class, 'toggleStatus'])->name('plans.toggle');
    Route::delete('/plans/{plan}', [App\Http\Controllers\AdminPricingPlanController::class, 'destroy'])->name('plans.destroy');

    // How It Works Steps Management CRUD Routes
    Route::get('/how-it-works', [App\Http\Controllers\AdminHowItWorksController::class, 'index'])->name('how-it-works.index');
    Route::get('/how-it-works/create', [App\Http\Controllers\AdminHowItWorksController::class, 'create'])->name('how-it-works.create');
    Route::post('/how-it-works', [App\Http\Controllers\AdminHowItWorksController::class, 'store'])->name('how-it-works.store');
    Route::get('/how-it-works/{howItWork}/edit', [App\Http\Controllers\AdminHowItWorksController::class, 'edit'])->name('how-it-works.edit');
    Route::put('/how-it-works/{howItWork}', [App\Http\Controllers\AdminHowItWorksController::class, 'update'])->name('how-it-works.update');
    Route::post('/how-it-works/{howItWork}/toggle', [App\Http\Controllers\AdminHowItWorksController::class, 'toggleStatus'])->name('how-it-works.toggle');
    Route::delete('/how-it-works/{howItWork}', [App\Http\Controllers\AdminHowItWorksController::class, 'destroy'])->name('how-it-works.destroy');

    // Users & Customers Management CRUD Routes
    Route::get('/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/toggle', [App\Http\Controllers\AdminUserController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name('users.destroy');

    // Coupons & Discounts Management CRUD Routes
    Route::get('/coupons', [App\Http\Controllers\AdminCouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [App\Http\Controllers\AdminCouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [App\Http\Controllers\AdminCouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}/edit', [App\Http\Controllers\AdminCouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}', [App\Http\Controllers\AdminCouponController::class, 'update'])->name('coupons.update');
    Route::post('/coupons/{coupon}/toggle', [App\Http\Controllers\AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle');
    Route::delete('/coupons/{coupon}', [App\Http\Controllers\AdminCouponController::class, 'destroy'])->name('coupons.destroy');

    // Payment Methods Management CRUD Routes
    Route::get('/payment-methods', [App\Http\Controllers\AdminPaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::get('/payment-methods/create', [App\Http\Controllers\AdminPaymentMethodController::class, 'create'])->name('payment-methods.create');
    Route::post('/payment-methods', [App\Http\Controllers\AdminPaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::get('/payment-methods/{paymentMethod}/edit', [App\Http\Controllers\AdminPaymentMethodController::class, 'edit'])->name('payment-methods.edit');
    Route::put('/payment-methods/{paymentMethod}', [App\Http\Controllers\AdminPaymentMethodController::class, 'update'])->name('payment-methods.update');
    Route::post('/payment-methods/{paymentMethod}/toggle', [App\Http\Controllers\AdminPaymentMethodController::class, 'toggleStatus'])->name('payment-methods.toggle');
    Route::delete('/payment-methods/{paymentMethod}', [App\Http\Controllers\AdminPaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');

    // Orders & Invoices Management
    Route::get('/orders', [App\Http\Controllers\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/approve', [App\Http\Controllers\AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{order}/cancel', [App\Http\Controllers\AdminOrderController::class, 'cancel'])->name('orders.cancel');

    // Customer Subscriptions & Licenses Management
    Route::get('/subscriptions', [App\Http\Controllers\AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create', [App\Http\Controllers\AdminSubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions', [App\Http\Controllers\AdminSubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}/edit', [App\Http\Controllers\AdminSubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/{subscription}', [App\Http\Controllers\AdminSubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::post('/subscriptions/{subscription}/status', [App\Http\Controllers\AdminSubscriptionController::class, 'updateStatus'])->name('subscriptions.status');
    Route::post('/subscriptions/{subscription}/extend', [App\Http\Controllers\AdminSubscriptionController::class, 'extend'])->name('subscriptions.extend');
    Route::delete('/subscriptions/{subscription}', [App\Http\Controllers\AdminSubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    // Payments & Manual / Office Payments Entry
    Route::get('/payments', [App\Http\Controllers\AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [App\Http\Controllers\AdminPaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/manual', [App\Http\Controllers\AdminPaymentController::class, 'storeManual'])->name('payments.store-manual');

    // Support Tickets Administration
    Route::get('/tickets', [App\Http\Controllers\AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [App\Http\Controllers\AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [App\Http\Controllers\AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/status', [App\Http\Controllers\AdminTicketController::class, 'updateStatus'])->name('tickets.status');
    Route::delete('/tickets/{ticket}', [App\Http\Controllers\AdminTicketController::class, 'destroy'])->name('tickets.destroy');

    // Dedicated Admin Notifications Page & Actions
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'adminIndex'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'adminMarkAllRead'])->name('notifications.mark-all-read');
    Route::match(['post', 'delete'], '/notifications/delete-all', [App\Http\Controllers\NotificationController::class, 'adminDeleteAll'])->name('notifications.delete-all');
    Route::get('/notifications/{notification}/go', [App\Http\Controllers\NotificationController::class, 'adminReadAndRedirect'])->name('notifications.read-and-redirect')->whereNumber('notification');
    Route::post('/notifications/{notification}/toggle-read', [App\Http\Controllers\NotificationController::class, 'adminToggleRead'])->name('notifications.toggle-read')->whereNumber('notification');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'adminDestroy'])->name('notifications.destroy')->whereNumber('notification');

    // Dedicated Site, Footer, Branding & SEO Settings
    Route::get('/site-settings', [App\Http\Controllers\AdminSiteSettingController::class, 'index'])->name('site-settings.index');
    Route::post('/site-settings', [App\Http\Controllers\AdminSiteSettingController::class, 'update'])->name('site-settings.update');

    // Dedicated SMTP & Mail Server Configuration
    Route::get('/smtp', [App\Http\Controllers\AdminSmtpController::class, 'edit'])->name('smtp.edit');
    Route::match(['put', 'post'], '/smtp', [App\Http\Controllers\AdminSmtpController::class, 'update'])->name('smtp.update');
    Route::post('/smtp/test', [App\Http\Controllers\AdminSmtpController::class, 'testMail'])->name('smtp.test');

    // System & Application Logs Viewer
    Route::get('/logs', [App\Http\Controllers\AdminLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/download', [App\Http\Controllers\AdminLogController::class, 'download'])->name('logs.download');
    Route::post('/logs/clear', [App\Http\Controllers\AdminLogController::class, 'clear'])->name('logs.clear');

    // Background Jobs & Queue Monitor
    Route::get('/queue-jobs', [App\Http\Controllers\AdminQueueController::class, 'index'])->name('queue.index');
    Route::get('/queue-jobs/metrics', [App\Http\Controllers\AdminQueueController::class, 'metrics'])->name('queue.metrics');
    Route::post('/queue-jobs/restart', [App\Http\Controllers\AdminQueueController::class, 'restartWorkers'])->name('queue.restart');
    Route::post('/queue-jobs/retry-all', [App\Http\Controllers\AdminQueueController::class, 'retryAll'])->name('queue.retry-all');
    Route::post('/queue-jobs/flush-failed', [App\Http\Controllers\AdminQueueController::class, 'flushFailedJobs'])->name('queue.flush-failed');
    Route::post('/queue-jobs/failed/{id}/retry', [App\Http\Controllers\AdminQueueController::class, 'retryJob'])->name('queue.failed.retry');
    Route::delete('/queue-jobs/failed/{id}', [App\Http\Controllers\AdminQueueController::class, 'deleteFailedJob'])->name('queue.failed.destroy');
    Route::delete('/queue-jobs/pending/{id}', [App\Http\Controllers\AdminQueueController::class, 'deletePendingJob'])->name('queue.pending.destroy');
});

/*
|--------------------------------------------------------------------------
| User Protected Routes (Role: user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');

    // Dedicated Profile Update Routes
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Dedicated Change Password Routes
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('password');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');

    // Available Active Pricing Plans
    Route::get('/plans', [UserController::class, 'plans'])->name('plans');

    // User Subscriptions, Orders & Payments
    Route::get('/subscriptions', [UserController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::post('/orders/{order}/cancel', [UserController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/payments', [UserController::class, 'payments'])->name('payments');
    Route::get('/orders/{order}/invoice', [UserController::class, 'invoice'])->name('invoice');

    // Dedicated User Notifications Page & Actions
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'userIndex'])->name('notifications');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'userMarkAllRead'])->name('notifications.mark-all-read');
    Route::match(['post', 'delete'], '/notifications/delete-all', [App\Http\Controllers\NotificationController::class, 'userDeleteAll'])->name('notifications.delete-all');
    Route::get('/notifications/{notification}/go', [App\Http\Controllers\NotificationController::class, 'userReadAndRedirect'])->name('notifications.read-and-redirect')->whereNumber('notification');
    Route::post('/notifications/{notification}/toggle-read', [App\Http\Controllers\NotificationController::class, 'userToggleRead'])->name('notifications.toggle-read')->whereNumber('notification');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'userDestroy'])->name('notifications.destroy')->whereNumber('notification');

    // User Support Tickets
    Route::get('/tickets', [App\Http\Controllers\UserTicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/create', [App\Http\Controllers\UserTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [App\Http\Controllers\UserTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [App\Http\Controllers\UserTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [App\Http\Controllers\UserTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/close', [App\Http\Controllers\UserTicketController::class, 'close'])->name('tickets.close');

    // Checkout & Payment Processing
    Route::get('/checkout/{plan?}', [UserController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/apply-coupon', [UserController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/checkout/remove-coupon', [UserController::class, 'removeCoupon'])->name('checkout.remove-coupon');
    Route::post('/checkout/process', [UserController::class, 'processCheckout'])->name('checkout.process');

    // Moneybag Payment Gateway Routes
    Route::get('/payment/initiate', [MoneybagPaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::match(['get', 'post'], '/payment/success', [MoneybagPaymentController::class, 'success'])->name('payment.success');
    Route::match(['get', 'post'], '/payment/fail', [MoneybagPaymentController::class, 'fail'])->name('payment.fail');
    Route::match(['get', 'post'], '/payment/cancel', [MoneybagPaymentController::class, 'cancel'])->name('payment.cancel');
});

// Moneybag Webhook / IPN (CSRF-exempt & accessible by gateway servers)
Route::post('/payment/moneybag/ipn', [MoneybagPaymentController::class, 'handleIpn'])->name('user.payment.ipn');
