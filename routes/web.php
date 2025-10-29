<?php
// routes/web.php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengajuanSuratController as AdminPengajuanSuratController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\PengajuanSuratController as WargaPengajuanSuratController;
use App\Http\Controllers\Warga\ProfileController as ProfileController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== AUTHENTICATION ROUTES ====================
// Login Routes
Route::get('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

// Register Routes (Hanya untuk warga)
Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// Logout Route
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// ==================== PROTECTED ROUTES (Harus Login) ====================
Route::middleware(['auth'])->group(function () {

    // ==================== WARGA ROUTES ====================
    Route::middleware(['auth', \App\Http\Middleware\WargaMiddleware::class])
    ->prefix('warga')
    ->name('warga.')
    ->group(function () {
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [WargaPengajuanSuratController::class, 'index'])->name('index');
            Route::get('/buat', [WargaPengajuanSuratController::class, 'create'])->name('create');
            Route::post('/buat', [WargaPengajuanSuratController::class, 'store'])->name('store');
            Route::get('/{id}', [WargaPengajuanSuratController::class, 'show'])->name('show');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])->name('show');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::post('/update', [ProfileController::class, 'update'])->name('update');
            Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
        });
    });

    // ==================== ADMIN ROUTES ====================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Management Pengajuan Surat
        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [AdminPengajuanSuratController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminPengajuanSuratController::class, 'show'])->name('show');
            Route::put('/{id}/update-status', [AdminPengajuanSuratController::class, 'updateStatus'])->name('update-status');
        });

        // Management Data Master (untuk future development)
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/jenis-surat', function () {
                return view('admin.data.jenis-surat');
            })->name('jenis-surat');

            Route::get('/warga', function () {
                return view('admin.data.warga');
            })->name('warga');
        });

    });

});

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
