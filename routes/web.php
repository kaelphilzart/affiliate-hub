<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');

Route::get('/r/{product}', [TrackingController::class, 'redirect'])
    ->name('track.redirect');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // PRODUCT
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::post('/products', 'store')->name('products.store');
        Route::put('/products/{product}', 'update')->name('products.update');
        Route::delete('/products/{product}', 'destroy')->name('products.destroy');
    });
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

require __DIR__.'/settings.php';
