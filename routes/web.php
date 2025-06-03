<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\KelolaPenggunaController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\LowonganMagangController;
use App\Http\Controllers\Admin\PerusahaanController;
use App\Http\Controllers\Admin\MagangController;
use App\Http\Controllers\Admin\LamaranController;
use App\Http\Controllers\Dosen\LogMahasiswaController;
use App\Http\Controllers\Dosen\MonitoringController;
use App\Http\Controllers\Mahasiswa\LowonganController;
use App\Http\Controllers\Mahasiswa\LogKegiatanController;
use App\Http\Controllers\Mahasiswa\RekomendasiController;
use App\Http\Controllers\Admin\KelolaInputController;

Route::pattern('id', '[0-9]+');

// ===================== AUTH ROUTES =====================
Route::get('/', [AuthController::class, 'landingPage'])->name('landingPpage');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postregister']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/test-email', function () {
    Mail::raw('Tes kirim email berhasil.', function ($message) {
        $message->to('hamdanizul24@gmail.com')
                ->subject('Test Email');
    });

    return 'Email terkirim';
});


// ===================== AUTHENTICATED ROUTES =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // ===================== ADMIN ROUTES =====================
    Route::middleware('authorize:admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard-admin', [DashboardController::class, 'dashboard_admin'])->name('dashboard_admin');

        // Profile routes
        Route::put('/profile/update-admin', [ProfileController::class, 'updateAdmin'])->name('profile.update');

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
            Route::post('toggle-status/{id}', [KelolaPenggunaController::class, 'toggleStatus']);
        });

        // Lamaran
        Route::prefix('lamaran')->name('lamaran.')->group(function () {
            Route::get('/', [LamaranController::class, 'index'])->name('index');
            Route::get('list', [LamaranController::class, 'list'])->name('list');
            Route::get('{id}/{detail}', [LamaranController::class, 'show'])->name('show');
            Route::put('{id}/status', [LamaranController::class, 'updateStatus'])->name('update-status');
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

        // Download Dokumen
        Route::get('/download/dokumen/{id}', [LamaranController::class, 'downloadDokumen'])->name('download.dokumen');

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

        Route::prefix('input-fasilitas')->name('input_fasilitas.')->group(function () {
            Route::get('/', [KelolaInputController::class, 'input_fasilitas'])->name('input_fasilitas');
            Route::post('/', [KelolaInputController::class, 'store_fasilitas'])->name('store_fasilitas');
            Route::delete('/{id}', [KelolaInputController::class, 'destroy_fasilitas'])->name('destroy_fasilitas');
        });

        Route::prefix('input-bidang-keahlian')->name('input_bidang_keahlian.')->group(function () {
            Route::get('/', [KelolaInputController::class, 'input_bidang_keahlian'])->name('input_bidang_keahlian');
            Route::post('/', [KelolaInputController::class, 'store_bidang_keahlian'])->name('store_bidang_keahlian');
            Route::delete('/{id}', [KelolaInputController::class, 'destroy_bidang_keahlian'])->name('destroy_bidang_keahlian');
        });

        Route::prefix('input-jenis-perusahaan')->name('input_jenis_perusahaan.')->group(function () {
            Route::get('/', [KelolaInputController::class, 'input_jenis_perusahaan'])->name('input_jenis_perusahaan');
            Route::post('/', [KelolaInputController::class, 'store_jenis_perusahaan'])->name('store_jenis_perusahaan');
            Route::delete('/{id}', [KelolaInputController::class, 'destroy_jenis_perusahaan'])->name('destroy_jenis_perusahaan');
        });
    });

    // ===================== MAHASISWA ROUTES =====================
    Route::middleware('authorize:mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard-mahasiswa', [DashboardController::class, 'dashboard_mahasiswa'])->name('dashboard.mahasiswa');
        Route::get('/daftar-lowongan', [LowonganController::class, 'index'])->name('daftar-lowongan.index');
        Route::get('/daftar-lowongan/{id}', [LowonganController::class, 'show'])->name('daftar-lowongan.show');

        // Profile routes
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
        Route::post('log-kegiatan/store', [LogKegiatanController::class, 'store'])->name('log-kegiatan.store');
        Route::get('log-kegiatan/{id}/edit', [LogKegiatanController::class, 'edit'])->name('log-kegiatan.edit');
        Route::put('log-kegiatan/{id}', [LogKegiatanController::class, 'update'])->name('log-kegiatan.update');
        Route::get('log-kegiatan/{id}/confirm', [LogKegiatanController::class, 'confirm']);
        Route::delete('log-kegiatan/{id}', [LogKegiatanController::class, 'destroy'])->name('log-kegiatan.destroy');

        Route::get('riwayat-magang', [MagangController::class, 'historyMagang']);
        Route::post('/lowongan/{id}/daftar', [LowonganController::class, 'daftarLamaran'])->name('lowongan.daftar');
        Route::post('/feedback/store', [LogMahasiswaController::class, 'storeFeedbackMahasiswa'])->name('feedback.store');

        Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    });


    // ===================== DOSEN ROUTES =====================
    Route::middleware('authorize:dosen_pembimbing')->name('dosen.')->group(function () {
        Route::get('/dashboard-dosen', [DashboardController::class, 'dashboard_dosen'])->name('dashboard_dosen');
        Route::get('/monitoring', [MonitoringController::class, 'index']);
        Route::get('/monitoring/list', [MonitoringController::class, 'list'])->name('monitoring.list');
        Route::get('/monitoring/{id}', [MonitoringController::class, 'show'])->name('monitoring.show');

        // Route untuk melihat dokumen log
        Route::get('/logs/documents/{id_dokumen}', [LogMahasiswaController::class, 'showDocument'])->name('admin.logs.document');

        // Route untuk menampilkan form feedback
        Route::get('/logs/{id_log}/feedback-form', [LogMahasiswaController::class, 'showFeedbackForm'])->name('admin.logs.feedback-form');

        // Route untuk menyimpan feedback
        Route::post('/logs/{id_log}/feedback', [LogMahasiswaController::class, 'storeFeedback'])->name('admin.logs.feedback');

        // Route umum terakhir agar tidak bentrok
        Route::get('/mahasiswa/{id}/logs', [LogMahasiswaController::class, 'show'])->name('admin.log-mahasiswa');

        // Profile routes
        Route::put('/profile/update-dosen', [ProfileController::class, 'updateDosen'])->name('profile.update');
    });
});
