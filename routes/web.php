<?php
// routes/web.php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengajuanSuratController as AdminPengajuanSuratController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\PengajuanSuratController as WargaPengajuanSuratController;
use App\Http\Controllers\Warga\ProfileController as WargaProfileController;
use App\Http\Controllers\Admin\DataWargaController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\WargaMiddleware;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return response()->json(['status' => 'OK', 'message' => 'Laravel is running']);
});

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
Route::middleware(['auth', 'prevent.back'])->group(function () {

    // ==================== WARGA ROUTES ====================
    Route::middleware([WargaMiddleware::class])
        ->prefix('warga')
        ->name('warga.')
        ->group(function () {

        // Dashboard Warga
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

        // Pengajuan Surat Routes
        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [WargaPengajuanSuratController::class, 'index'])->name('index');
            Route::get('/buat', [WargaPengajuanSuratController::class, 'create'])->name('create');
            Route::post('/buat', [WargaPengajuanSuratController::class, 'store'])->name('store');
            Route::get('/{id}', [WargaPengajuanSuratController::class, 'show'])->name('show');
        });

        // Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [WargaProfileController::class, 'show'])->name('show');
            Route::get('/edit', [WargaProfileController::class, 'edit'])->name('edit');
            Route::post('/update', [WargaProfileController::class, 'update'])->name('update');
            Route::post('/update-password', [WargaProfileController::class, 'updatePassword'])->name('update-password');
        });
    });

    // ==================== ADMIN ROUTES ====================
    Route::middleware([AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Management Pengajuan Surat
        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [AdminPengajuanSuratController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminPengajuanSuratController::class, 'show'])->name('show');
            Route::post('/{id}/update-status', [AdminPengajuanSuratController::class, 'updateStatus'])->name('update-status');
        });

        // Management Data Master
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/warga', function () {
                return view('admin.data.warga');
            })->name('warga');

            Route::get('/jenis-surat', function () {
                return view('admin.data.jenis-surat');
            })->name('jenis-surat');
        });
        Route::prefix('data')->name('data.')->group(function () {
            // Data Warga
            Route::get('/warga', [DataWargaController::class, 'index'])->name('warga');
            Route::get('/warga/{id}', [DataWargaController::class, 'show'])->name('warga-show');

            // Jenis Surat
            Route::get('/jenis-surat', [JenisSuratController::class, 'index'])->name('jenis-surat');
            Route::post('/jenis-surat/store', [JenisSuratController::class, 'store'])->name('jenis-surat-store');
            Route::put('/jenis-surat/{id}/update', [JenisSuratController::class, 'update'])->name('jenis-surat-update');
            Route::delete('/jenis-surat/{id}/destroy', [JenisSuratController::class, 'destroy'])->name('jenis-surat-destroy');
        });
    });

});

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
