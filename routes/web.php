<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendonorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/tentang-kami', 'tentang-kami');
Route::view('/stok-plasma', 'stok-plasma');
Route::view('/kontak', 'kontak');
Route::view('/masuk', 'masuk');
Route::view('/daftar', 'daftar');
Route::view('/daftar-donor', 'daftar-donor');
Route::view('/daftar-pendonor', 'daftar-pendonor');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::view('/welcome', 'welcome')->name('welcome');

    Route::view('/dashboard', 'pages.pasien.dashboard')->name('dashboard');
    Route::get('/stok-plasma-donor', [HospitalController::class, 'showHospitalPasien'])->name('stok-plasma-donor');
    Route::view('/permohonan', 'pages.pasien.permohonan')->name('permohonan');
    Route::post('/permohonan', [PasienController::class, 'store'])->name('permohonan.store');
    Route::get('/faq-donor', [FaqController::class, 'showFaq'])->name('faq.donor');
    Route::get('/berita-donor', [BeritaController::class, 'showBerita'])->name('berita.donor');
    Route::view('/user-profile', 'pages.pasien.user-profile')->name('user-profile');
    Route::get('/change-password', [PasienController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [PasienController::class, 'updatePassword'])->name('change-password.update');
    Route::get('/change-email', [PasienController::class, 'changeEmail'])->name('change-email');
    Route::post('/change-email', [PasienController::class, 'updateEmail'])->name('change-email.update');

    Route::view('/dashboard-pendonor', 'pages.pendonor.dashboard-pendonor')->name('dashboard-pendonor');
    Route::get('/stok-plasma-pendonor', [HospitalController::class, 'showHospital'])->name('stok-plasma-pendonor');
    Route::view('/pendonor', 'pages.pendonor.pendonor')->name('pendonor');
    Route::post('/pendonor', [PendonorController::class, 'store'])->name('pendonor.store');
    Route::view('/faq-pendonor', 'pages.pendonor.faq')->name('faq.pendonor');
    Route::get('/berita-pendonor', [BeritaController::class, 'showBerita'])->name('berita.pendonor');
    Route::view('/user-profile-pendonor', 'pages.pendonor.user-profile')->name('user-profile-pendonor');
    Route::get('/change-password-pendonor', [PendonorController::class, 'changePassword'])->name('change-password-pendonor');
    Route::post('/change-password-pendonor', [PendonorController::class, 'updatePassword'])->name('change-password-pendonor.update');
    Route::get('/change-email-pendonor', [PendonorController::class, 'changeEmail'])->name('change-email-pendonor');
    Route::post('/change-email-pendonor', [PendonorController::class, 'updateEmail'])->name('change-email-pendonor.update');
    Route::get('/list-pendonor', [PendonorController::class, 'show'])->name('list-pendonor');

    Route::view('/dashboard-admin', 'pages.user.dashboard-admin')->name('dashboard.admin');

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::view('/user/new', 'pages.user.user-new')->name('user.new');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{userId}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete/{userId}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/change-password-admin', [UserController::class, 'changePassword'])->name('change-password-admin');
    Route::post('/change-password-admin', [UserController::class, 'updatePassword'])->name('change-password-admin.update');
    Route::get('/change-email-admin', [UserController::class, 'changeEmail'])->name('change-email-admin');
    Route::post('/change-email-admin', [UserController::class, 'updateEmail'])->name('change-email-admin.update');

    Route::get('/hospital', [HospitalController::class, 'index'])->name('hospital');
    Route::view('/hospital/new', 'pages.hospital.hospital-new')->name('hospital.new');
    Route::post('/hospital/submit', [HospitalController::class, 'store'])->name('hospital.store');
    Route::get('/hospital/edit/{hospital}', [HospitalController::class, 'edit'])->name('hospital.edit');
    Route::post('/hospital/update/{hospital}', [HospitalController::class, 'update'])->name('hospital.update');
    Route::get('/hospital/delete/{hospital}', [HospitalController::class, 'destroy'])->name('hospital.delete');

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
    Route::view('/berita/new', 'pages.berita.berita-new')->name('berita.new');
    Route::post('/berita/submit', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/edit/{beritaId}', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::post('/berita/update/{beritaId}', [BeritaController::class, 'update'])->name('berita.update');
    Route::get('/berita/delete/{beritaId}', [BeritaController::class, 'destroy'])->name('berita.delete');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::view('/faq/new', 'pages.faq.faq-new')->name('faq.new');
    Route::post('/faq/submit', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faq/edit/{faq}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('/faq/update/{faq}', [FaqController::class, 'update'])->name('faq.update');
    Route::get('/faq/delete/{faq}', [FaqController::class, 'destroy'])->name('faq.delete');
});
