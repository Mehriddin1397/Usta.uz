<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/masters/{master}', [MasterController::class, 'show'])->name('masters.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/language/{locale}', [LanguageController::class, 'change'])->name('language.change');

// Authentication routes (will be added with Breeze)
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/masters/{master}/order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/masters/{master}/order', [OrderController::class, 'store'])->name('orders.store');
    
    // Reviews
    Route::get('/orders/{order}/review', [OrderController::class, 'createReview'])->name('orders.review.create');
    Route::post('/orders/{order}/review', [OrderController::class, 'storeReview'])->name('orders.review.store');
});

// Master routes
Route::middleware(['auth', 'role:master'])->group(function () {
    Route::get('/master/dashboard', [MasterController::class, 'dashboard'])->name('master.dashboard');
    Route::get('/master/works/create', [MasterController::class, 'createWork'])->name('master.works.create');
    Route::post('/master/works', [MasterController::class, 'storeWork'])->name('master.works.store');
    Route::post('/master/orders/{order}/accept', [MasterController::class, 'acceptOrder'])->name('master.orders.accept');
    Route::post('/master/orders/{order}/complete', [MasterController::class, 'completeOrder'])->name('master.orders.complete');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/masters/pending', [AdminController::class, 'pendingMasters'])->name('admin.masters.pending');
    Route::post('/admin/masters/{master}/approve', [AdminController::class, 'approveMaster'])->name('admin.masters.approve');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/admin/regions', [AdminController::class, 'regions'])->name('admin.regions');
    Route::post('/admin/regions', [AdminController::class, 'storeRegion'])->name('admin.regions.store');
});
