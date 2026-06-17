<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Marketplace\MarketplaceController;
use App\Http\Controllers\Marketplace\VendorController;
use App\Http\Controllers\Marketplace\PurchaseController;

Route::name('marketplace.')->prefix('marketplace')->group(function () {

    // Public Browse
    Route::get('/', [MarketplaceController::class, 'index'])->name('index');
    Route::get('/{id}', [MarketplaceController::class, 'show'])->name('show');

    // Vendor Area (Auth)
    Route::middleware(['auth'])->group(function () {
        Route::get('vendor/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
        Route::get('vendor/products', [VendorController::class, 'myProducts'])->name('vendor.products');
        Route::get('vendor/create', [VendorController::class, 'create'])->name('vendor.create');
        Route::post('vendor/store', [VendorController::class, 'store'])->name('vendor.store');

        // Purchase
        Route::post('buy/{id}', [PurchaseController::class, 'buy'])->name('buy');
        Route::get('library', [PurchaseController::class, 'library'])->name('library');
        Route::get('download/{id}', [PurchaseController::class, 'download'])->name('download');
    });

});
