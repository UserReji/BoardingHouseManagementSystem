<?php

use App\Http\Controllers\Manager\AnnouncementController;
use App\Http\Controllers\Manager\BillingPeriodController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\GCashController;
use App\Http\Controllers\Manager\MeterReadingController;
use App\Http\Controllers\Manager\PhotoController;
use App\Http\Controllers\Manager\ReceiptReviewController;
use App\Http\Controllers\Manager\ReportController;
use App\Http\Controllers\Manager\SettingsController;
use App\Http\Controllers\Manager\TenantBillController;
use App\Http\Controllers\Manager\TenantController;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')
    ->name('manager.')
    ->middleware(['auth', 'role:manager'])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('tenants', TenantController::class);
        Route::resource('billing-periods', BillingPeriodController::class);
        Route::resource('tenant-bills', TenantBillController::class);
        Route::resource('meter-readings', MeterReadingController::class);
        Route::resource('photos', PhotoController::class)->except(['edit', 'update']);
        Route::resource('announcements', AnnouncementController::class);

        Route::get('receipts', [ReceiptReviewController::class, 'index'])->name('receipts.index');
        Route::get('receipts/{receipt}', [ReceiptReviewController::class, 'show'])->name('receipts.show');
        Route::patch('receipts/{receipt}', [ReceiptReviewController::class, 'update'])->name('receipts.update');

        Route::get('gcash', [GCashController::class, 'index'])->name('gcash.index');
        Route::get('gcash/{gcash}/edit', [GCashController::class, 'edit'])->name('gcash.edit');
        Route::patch('gcash/{gcash}', [GCashController::class, 'update'])->name('gcash.update');

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    });
