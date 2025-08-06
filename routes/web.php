<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pemesanan Tiket (User)
    Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
        Route::get('/', [PemesananController::class, 'index'])->name('index');
        Route::get('/search', [PemesananController::class, 'search'])->name('search');
        Route::get('/create/{armada}', [PemesananController::class, 'create'])->name('create');
        Route::post('/store', [PemesananController::class, 'store'])->name('store');
        Route::get('/show/{pemesanan}', [PemesananController::class, 'show'])->name('show');
        Route::get('/my-orders', [PemesananController::class, 'myOrders'])->name('my-orders');
    });

    // Pembayaran
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/create/{pemesanan}', [PembayaranController::class, 'create'])->name('create');
        Route::post('/store', [PembayaranController::class, 'store'])->name('store');
        
        // Admin only
        Route::middleware(['auth', 'role:admin,owner'])->group(function () {
            Route::post('/verify/{pembayaran}', [PembayaranController::class, 'verify'])->name('verify');
            Route::post('/reject/{pembayaran}', [PembayaranController::class, 'reject'])->name('reject');
        });
    });

    // Tiket (Reschedule & Pembatalan)
    Route::prefix('tiket')->name('tiket.')->group(function () {
        Route::get('/reschedule/{tiket}', [TiketController::class, 'reschedule'])->name('reschedule');
        Route::post('/reschedule', [TiketController::class, 'storeReschedule'])->name('reschedule.store');
        Route::get('/cancel/{tiket}', [TiketController::class, 'cancel'])->name('cancel');
        Route::post('/cancel', [TiketController::class, 'storeCancel'])->name('cancel.store');
    });

    // Admin Routes
    Route::middleware(['auth', 'role:admin,owner'])->prefix('admin')->name('admin.')->group(function () {
        // Armada Management
        Route::prefix('armada')->name('armada.')->group(function () {
            Route::get('/', [AdminController::class, 'armadaIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'armadaCreate'])->name('create');
            Route::post('/store', [AdminController::class, 'armadaStore'])->name('store');
        });

        // Pembayaran Verification
        Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
            Route::get('/', [AdminController::class, 'pembayaranIndex'])->name('index');
        });

        // Reschedule Management
        Route::prefix('reschedule')->name('reschedule.')->group(function () {
            Route::get('/', [AdminController::class, 'rescheduleIndex'])->name('index');
            Route::post('/approve/{reschedule}', [AdminController::class, 'rescheduleApprove'])->name('approve');
        });

        // Pembatalan Management
        Route::prefix('pembatalan')->name('pembatalan.')->group(function () {
            Route::get('/', [AdminController::class, 'pembatalanIndex'])->name('index');
            Route::post('/approve/{pembatalan}', [AdminController::class, 'pembatalanApprove'])->name('approve');
        });
    });

    // Owner Routes (Laporan)
    Route::middleware(['auth', 'role:owner'])->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
    });
});

require __DIR__.'/auth.php';