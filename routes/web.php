<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\KelolaPenggunaController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\LowonganMagangController;
use App\Http\Controllers\Admin\PerusahaanController;
use App\Http\Controllers\Admin\MagangController;
use App\Http\Controllers\Admin\LamaranController;
use App\Http\Controllers\Mahasiswa\LowonganController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Mahasiswa\LogKegiatanController;

Route::pattern('id', '[0-9]+');

// ===================== AUTH ROUTES =====================
Route::get('/', [AuthController::class, 'landingPage'])->name('landingPpage');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postregister']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

// ===================== AUTHENTICATED ROUTES =====================
Route::middleware('auth')->group(function () {

    // ===================== ADMIN ROUTES =====================
    Route::middleware('authorize:admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard-admin', [DashboardController::class, 'dashboard_admin'])->name('dashboard_admin');

        // Kelola Pengguna
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [KelolaPenggunaController::class, 'index'])->name('index');
            Route::get('list', [KelolaPenggunaController::class, 'list'])->name('list');
            Route::get('create-ajax', [KelolaPenggunaController::class, 'create_ajax'])->name('create_ajax');
            Route::post('store-ajax', [KelolaPenggunaController::class, 'store_ajax'])->name('store_ajax');
            Route::get('{id}/edit-ajax', [KelolaPenggunaController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('{id}/update-ajax', [KelolaPenggunaController::class, 'update_ajax'])->name('update_ajax');
            Route::get('{id}/show-ajax', [KelolaPenggunaController::class, 'show_ajax'])->name('show_ajax');
            Route::get('{id}/confirm-ajax', [KelolaPenggunaController::class, 'confirm_ajax'])->name('confirm_ajax');
            Route::delete('{id}/delete-ajax', [KelolaPenggunaController::class, 'delete_ajax'])->name('delete_ajax');
            Route::get('{id}/reset-password', [KelolaPenggunaController::class, 'resetPasswordForm'])->name('reset_password_form');
            Route::post('{id}/reset-password', [KelolaPenggunaController::class, 'resetPassword'])->name('reset_password');
        });

        // Lamaran
        Route::prefix('lamaran')->name('lamaran.')->group(function () {
            Route::get('/', [LamaranController::class, 'index'])->name('index');
            Route::get('{id}', [LamaranController::class, 'show'])->name('show');
            Route::put('{id}/status', [LamaranController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('{id}', [LamaranController::class, 'destroy'])->name('destroy');
        });

        // Lowongan Magang
        Route::prefix('lowongan')->name('lowongan.')->group(function () {
            Route::get('/', [LowonganMagangController::class, 'index'])->name('index');
            Route::get('list', [LowonganMagangController::class, 'list'])->name('list');
            Route::get('create-ajax', [LowonganMagangController::class, 'create_ajax'])->name('create_ajax');
            Route::post('store-ajax', [LowonganMagangController::class, 'store_ajax'])->name('store_ajax');
            Route::get('{id}/edit-ajax', [LowonganMagangController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('{id}/update-ajax', [LowonganMagangController::class, 'update_ajax'])->name('update_ajax');
            Route::get('{id}/show-ajax', [LowonganMagangController::class, 'show_ajax'])->name('show_ajax');
            Route::get('{id}/confirm-ajax', [LowonganMagangController::class, 'confirm_ajax'])->name('confirm_ajax');
            Route::delete('{id}/delete-ajax', [LowonganMagangController::class, 'delete_ajax'])->name('delete_ajax');
        });

        // Magang
        Route::prefix('magang')->name('magang.')->group(function () {
            Route::get('/', [MagangController::class, 'index'])->name('index');
            Route::get('{id}', [MagangController::class, 'show'])->name('show');
            Route::post('/', [MagangController::class, 'store'])->name('store');
            Route::get('feedback', [MagangController::class, 'feedback'])->name('feedback');
        });

        // Periode
        Route::prefix('periode')->name('periode.')->group(function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('index');
            Route::get('list', [PeriodeController::class, 'list'])->name('list');
            Route::get('create-ajax', [PeriodeController::class, 'create_ajax'])->name('create_ajax');
            Route::post('store-ajax', [PeriodeController::class, 'store_ajax'])->name('store_ajax');
            Route::get('{id}/edit-ajax', [PeriodeController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('{id}/update-ajax', [PeriodeController::class, 'update_ajax'])->name('update_ajax');
            Route::get('{id}/show-ajax', [PeriodeController::class, 'show_ajax'])->name('show_ajax');
            Route::post('{id}/delete-ajax', [PeriodeController::class, 'delete_ajax'])->name('delete_ajax');
            Route::get('{id}/confirm-ajax', [PeriodeController::class, 'confirm_ajax'])->name('confirm_ajax');
        });

        // Perusahaan
        Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
            Route::get('/', [PerusahaanController::class, 'index'])->name('index');
            Route::get('list', [PerusahaanController::class, 'list'])->name('list');
            Route::get('create-ajax', [PerusahaanController::class, 'create_ajax'])->name('create_ajax');
            Route::post('store-ajax', [PerusahaanController::class, 'store_ajax'])->name('store_ajax');
            Route::get('{id}/edit-ajax', [PerusahaanController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('{id}/update-ajax', [PerusahaanController::class, 'update_ajax'])->name('update_ajax');
            Route::get('{id}/show-ajax', [PerusahaanController::class, 'show_ajax'])->name('show_ajax');
            Route::post('{id}/delete-ajax', [PerusahaanController::class, 'delete_ajax'])->name('delete_ajax');
            Route::get('{id}/confirm-ajax', [PerusahaanController::class, 'confirm_ajax'])->name('confirm_ajax');
        });

        // Program Studi
        Route::prefix('program-studi')->name('programstudi.')->group(function () {
            Route::get('/', [ProgramStudiController::class, 'index'])->name('index');
            Route::get('list', [ProgramStudiController::class, 'list'])->name('list');
            Route::get('create-ajax', [ProgramStudiController::class, 'create_ajax'])->name('create_ajax');
            Route::post('store-ajax', [ProgramStudiController::class, 'store_ajax'])->name('store_ajax');
            Route::get('{id}/edit-ajax', [ProgramStudiController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('{id}/update-ajax', [ProgramStudiController::class, 'update_ajax'])->name('update_ajax');
            Route::get('{id}/show-ajax', [ProgramStudiController::class, 'show_ajax'])->name('show_ajax');
            Route::post('{id}/delete-ajax', [ProgramStudiController::class, 'delete_ajax'])->name('delete_ajax');
            Route::get('{id}/confirm-ajax', [ProgramStudiController::class, 'confirm_ajax'])->name('confirm_ajax');
        });
    });

    // ===================== MAHASISWA ROUTES =====================
    Route::middleware('authorize:mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard-mahasiswa', [DashboardController::class, 'dashboard_mahasiswa'])->name('dashboard.mahasiswa');
        Route::get('/daftar-lowongan', [LowonganController::class, 'index'])->name('daftar-lowongan.index');
        Route::get('/daftar-lowongan/{id}', [LowonganController::class, 'show'])->name('daftar-lowongan.show');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Pengalaman kerja
        Route::get('/profile/pengalaman/create', [ProfileController::class, 'createPengalaman'])->name('profile.pengalaman.create');
        Route::post('/profile/pengalaman/store', [ProfileController::class, 'storePengalaman'])->name('profile.pengalaman.store');
        Route::get('/profile/pengalaman/{id}/edit', [ProfileController::class, 'editPengalaman'])->name('profile.pengalaman.edit');
        Route::put('/profile/pengalaman/{id}', [ProfileController::class, 'updatePengalaman'])->name('profile.pengalaman.update');
        Route::delete('/profile/pengalaman/{id}', [ProfileController::class, 'destroyPengalaman'])->name('profile.pengalaman.destroy');

        // Dokumen
        Route::get('/profile/dokumen/create', [ProfileController::class, 'createDokumen'])->name('profile.dokumen.create');
        Route::post('/profile/dokumen/store', [ProfileController::class, 'storeDokumen'])->name('profile.dokumen.store');
        Route::get('/profile/dokumen/{id}/edit', [ProfileController::class, 'editDokumen'])->name('profile.dokumen.edit');
        Route::put('/profile/dokumen/{id}', [ProfileController::class, 'updateDokumen'])->name('profile.dokumen.update');
        Route::get('/profile/dokumen/download-cv', [ProfileController::class, 'downloadCV'])->name('profile.dokumen.downloadCV');
        Route::delete('/profile/dokumen/{id}', [ProfileController::class, 'destroyDokumen'])->name('profile.dokumen.destroy');

        // Log Kegiatan
        Route::get('log-kegiatan', [LogKegiatanController::class, 'index'])->name('log-kegiatan.index');
        Route::get('log-kegiatan/create', [LogKegiatanController::class, 'create'])->name('log-kegiatan.create');
        Route::post('log-kegiatan', [LogKegiatanController::class, 'store'])->name('log-kegiatan.store');
        Route::get('log-kegiatan/{id}/edit', [LogKegiatanController::class, 'edit'])->name('log-kegiatan.edit');
        Route::put('log-kegiatan/{id}', [LogKegiatanController::class, 'update'])->name('log-kegiatan.update');
        Route::delete('log-kegiatan/{id}', [LogKegiatanController::class, 'destroy'])->name('log-kegiatan.destroy');
    });


    // ===================== DOSEN ROUTES =====================
    Route::middleware('authorize:dosen_pembimbing')->group(function () {
        Route::get('/dashboard-dosen', [DashboardController::class, 'dashboard_dosen'])->name('dashboard_dosen');
        Route::get('dosen/list-mahasiswa', fn() => view('dosen.monitoring.list_mahasiswa'))->name('list-mahasiswa');
        Route::get('dosen/log-mahasiswa', fn() => view('dosen.monitoring.log_mahasiswa'))->name('log-mahasiswa');
    });
});
