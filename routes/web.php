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
    return view('welcome', compact('plans'));
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

    // Pricing Plans Management CRUD Routes
    Route::get('/plans', [App\Http\Controllers\AdminPricingPlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [App\Http\Controllers\AdminPricingPlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [App\Http\Controllers\AdminPricingPlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [App\Http\Controllers\AdminPricingPlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [App\Http\Controllers\AdminPricingPlanController::class, 'update'])->name('plans.update');
    Route::post('/plans/{plan}/toggle', [App\Http\Controllers\AdminPricingPlanController::class, 'toggleStatus'])->name('plans.toggle');
    Route::delete('/plans/{plan}', [App\Http\Controllers\AdminPricingPlanController::class, 'destroy'])->name('plans.destroy');

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
