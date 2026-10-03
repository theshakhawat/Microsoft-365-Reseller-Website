<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
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
});
