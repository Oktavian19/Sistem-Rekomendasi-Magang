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
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Mahasiswa\LowonganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::pattern('id', '[0-9]+');

// Authentication Routes
Route::get('/', [AuthController::class, 'landing_page'])->name('landing_page');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postregister']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {

    // ===================== ADMIN ROUTES =====================
    Route::middleware('authorize:admin')->name('admin.')->group(function () {
        // Dashboard Controller
        Route::get('/dashboard', [DashboardController::class, 'dashboard_admin'])->name('dashboard');

        // ===== KelolaPenggunaController Routes =====
        Route::get('user', [KelolaPenggunaController::class, 'index'])->name('user.index');
        Route::get('user/list', [KelolaPenggunaController::class, 'list'])->name('user.list');
        Route::get('user/create-ajax', [KelolaPenggunaController::class, 'create_ajax'])->name('user.create_ajax');
        Route::post('user/store-ajax', [KelolaPenggunaController::class, 'store_ajax'])->name('user.store_ajax');
        Route::get('user/{id}/edit-ajax', [KelolaPenggunaController::class, 'edit_ajax'])->name('user.edit_ajax');
        Route::post('user/{id}/update-ajax', [KelolaPenggunaController::class, 'update_ajax'])->name('user.update_ajax');
        Route::get('user/{id}/show-ajax', [KelolaPenggunaController::class, 'show_ajax'])->name('user.show_ajax');
        Route::get('user/{id}/confirm-ajax', [KelolaPenggunaController::class, 'confirm_ajax'])->name('user.confirm_ajax');
        Route::delete('user/{id}/delete-ajax', [KelolaPenggunaController::class, 'delete_ajax'])->name('user.delete_ajax');
        Route::get('user/{id}/reset-password', [KelolaPenggunaController::class, 'resetPasswordForm'])->name('user.reset_password_form');
        Route::post('user/{id}/reset-password', [KelolaPenggunaController::class, 'resetPassword'])->name('user.reset_password');
        // Reset password
        Route::get('user/{id}/reset-password', [KelolaPenggunaController::class, 'resetPasswordForm'])->name('user.reset_password_form');
        Route::post('user/{id}/reset-password', [KelolaPenggunaController::class, 'resetPassword'])->name('user.reset_password');

        // ===== LamaranController Routes =====
        Route::get('lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::get('lamaran/{id}', [LamaranController::class, 'show'])->name('lamaran.show');
        Route::put('lamaran/{id}/status', [LamaranController::class, 'updateStatus'])->name('lamaran.updateStatus');
        Route::delete('lamaran/{id}', [LamaranController::class, 'destroy'])->name('lamaran.destroy');

        // ===== LowonganMagangController Routes =====
        Route::get('lowongan', [LowonganMagangController::class, 'index'])->name('lowongan.index');
        Route::get('lowongan/list', [LowonganMagangController::class, 'list'])->name('lowongan.list');
        Route::get('lowongan/create-ajax', [LowonganMagangController::class, 'create_ajax'])->name('lowongan.create_ajax');
        Route::post('lowongan/store-ajax', [LowonganMagangController::class, 'store_ajax'])->name('lowongan.store_ajax');
        Route::get('lowongan/{id}/edit-ajax', [LowonganMagangController::class, 'edit_ajax'])->name('lowongan.edit_ajax');
        Route::post('lowongan/{id}/update-ajax', [LowonganMagangController::class, 'update_ajax'])->name('lowongan.update_ajax');
        Route::get('lowongan/{id}/show-ajax', [LowonganMagangController::class, 'show_ajax'])->name('lowongan.show_ajax');
        Route::get('lowongan/{id}/confirm-ajax', [LowonganMagangController::class, 'confirm_ajax'])->name('lowongan.confirm_ajax');
        Route::delete('lowongan/{id}/delete-ajax', [LowonganMagangController::class, 'delete_ajax'])->name('lowongan.delete_ajax');

        // ===== MagangController Routes =====
        Route::get('magang', [MagangController::class, 'index'])->name('magang.index');
        Route::get('magang/{id}', [MagangController::class, 'show'])->name('magang.show');
        Route::post('magang', [MagangController::class, 'store'])->name('magang.store');
        Route::get('magang-feedback', [MagangController::class, 'feedback'])->name('magang.feedback');

        // ===== PeriodeController Routes =====
        Route::get('periode', [PeriodeController::class, 'index'])->name('periode.index');
        Route::get('periode/list', [PeriodeController::class, 'list'])->name('periode.list');
        Route::get('periode/create-ajax', [PeriodeController::class, 'create_ajax'])->name('periode.create_ajax');
        Route::post('periode/store-ajax', [PeriodeController::class, 'store_ajax'])->name('periode.store_ajax');
        Route::get('periode/{id}/edit-ajax', [PeriodeController::class, 'edit_ajax'])->name('periode.edit_ajax');
        Route::post('periode/{id}/update-ajax', [PeriodeController::class, 'update_ajax'])->name('periode.update_ajax');
        Route::get('periode/{id}/show-ajax', [PeriodeController::class, 'show_ajax'])->name('periode.show_ajax');
        Route::post('periode/{id}/delete-ajax', [PeriodeController::class, 'delete_ajax'])->name('periode.delete_ajax');
        Route::get('periode/{id}/confirm-ajax', [PeriodeController::class, 'confirm_ajax'])->name('periode.confirm_ajax');

        // ===== PerusahaanController Routes =====
        Route::get('perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');
        Route::get('perusahaan/list', [PerusahaanController::class, 'list'])->name('perusahaan.list');
        Route::get('perusahaan/create-ajax', [PerusahaanController::class, 'create_ajax'])->name('perusahaan.create_ajax');
        Route::post('perusahaan/store-ajax', [PerusahaanController::class, 'store_ajax'])->name('perusahaan.store_ajax');
        Route::get('perusahaan/{id}/edit-ajax', [PerusahaanController::class, 'edit_ajax'])->name('perusahaan.edit_ajax');
        Route::post('perusahaan/{id}/update-ajax', [PerusahaanController::class, 'update_ajax'])->name('perusahaan.update_ajax');
        Route::get('perusahaan/{id}/show-ajax', [PerusahaanController::class, 'show_ajax'])->name('perusahaan.show_ajax');
        Route::post('perusahaan/{id}/delete-ajax', [PerusahaanController::class, 'delete_ajax'])->name('perusahaan.delete_ajax');
        Route::get('perusahaan/{id}/confirm-ajax', [PerusahaanController::class, 'confirm_ajax'])->name('perusahaan.confirm_ajax');

        // ===== ProgramStudiController Routes =====
        Route::get('program-studi', [ProgramStudiController::class, 'index'])->name('programstudi.index');
        Route::get('program-studi/list', [ProgramStudiController::class, 'list'])->name('programstudi.list');
        Route::get('program-studi/create-ajax', [ProgramStudiController::class, 'create_ajax'])->name('programstudi.create_ajax');
        Route::post('program-studi/store-ajax', [ProgramStudiController::class, 'store_ajax'])->name('programstudi.store_ajax');
        Route::get('program-studi/{id}/edit-ajax', [ProgramStudiController::class, 'edit_ajax'])->name('programstudi.edit_ajax');
        Route::post('program-studi/{id}/update-ajax', [ProgramStudiController::class, 'update_ajax'])->name('programstudi.update_ajax');
        Route::get('program-studi/{id}/show-ajax', [ProgramStudiController::class, 'show_ajax'])->name('programstudi.show_ajax');
        Route::post('program-studi/{id}/delete-ajax', [ProgramStudiController::class, 'delete_ajax'])->name('programstudi.delete_ajax');
        Route::get('program-studi/{id}/confirm-ajax', [ProgramStudiController::class, 'confirm_ajax'])->name('programstudi.confirm_ajax');
    });

    // ===================== MAHASISWA ROUTES =====================
    Route::middleware('authorize:mahasiswa')->group(function () {
        Route::get('/dashboard-mahasiswa', [DashboardController::class, 'dashboard_mahasiswa'])->name('dashboard.mahasiswa');
        Route::get('/daftar-lowongan', function () {
            return view('mahasiswa.magang.lowongan');
        })->name('lowongan-magang');
        

    });

    // ===================== DOSEN ROUTES =====================
    Route::middleware('authorize:dosen_pembimbing')->group(function () {
        // Dosen routes can be added here
    });
});
