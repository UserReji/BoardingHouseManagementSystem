<?php

use App\Http\Controllers\Tenant\AnnouncementController;
use App\Http\Controllers\Tenant\BillController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\GalleryController;
use App\Http\Controllers\Tenant\GCashController;
use App\Http\Controllers\Tenant\MeterReadingController;
use App\Http\Controllers\Tenant\PaymentController;
use App\Http\Controllers\Tenant\ProfileController;
use App\Http\Controllers\Tenant\ReceiptController;
use Illuminate\Support\Facades\Route;

Route::prefix('tenant')
    ->name('tenant.')
    ->middleware(['auth', 'role:tenant'])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('bills', BillController::class)->only(['index', 'show']);
        Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('receipts', ReceiptController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('meter-readings', MeterReadingController::class)->only(['index', 'show']);
        Route::get('gcash', [GCashController::class, 'show'])->name('gcash.show');
        Route::resource('gallery', GalleryController::class)->only(['index', 'show'])->parameters(['gallery' => 'photo']);
        Route::resource('announcements', AnnouncementController::class)->only(['index', 'show']);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
