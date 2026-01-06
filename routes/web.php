<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/register', [AdminAuthController::class, 'register']);

    Route::middleware(['auth:admin', 'prevent.back.history'])->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('admin.password.edit');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.password.update');

        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('admin.customers.store');
        Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');
        Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
        Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
        Route::put('/customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('admin.customers.toggle-status');
        Route::get('/customers/status', [CustomerController::class, 'getStatus'])->name('admin.customers.status');

        Route::resource('products', ProductController::class)->names('admin.products');
    });
});

Route::middleware(['auth:admin'])->group(function () {

    Route::get('products/import', [ProductImportController::class, 'create'])->name('admin.products.import');
    Route::post('products/import', [ProductImportController::class, 'store'])->name('admin.products.import.store');

});

Route::prefix('customer')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::post('/register', [CustomerAuthController::class, 'register']);

    Route::middleware(['auth:customer', 'prevent.back.history', 'customer.active'])->group(function () {
        Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

        Route::get('/profile', [CustomerProfileController::class, 'index'])->name('customer.profile.index');
        Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
        Route::put('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
        Route::get('/profile/password', [CustomerProfileController::class, 'editPassword'])->name('customer.password.edit');
        Route::put('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('customer.password.update');
    });
});
