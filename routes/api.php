<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Akses PJ Perusahaan */

// Verify email
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerifyEmailController::class, 'verifyEmail'])
    ->middleware(['auth:sanctum', 'signed'])
    ->name('verification.verify');

// Resend verification email
Route::post('/email/resend-verification', [App\Http\Controllers\Auth\VerifyEmailController::class, 'sendVerificationEmail'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

// Register
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);

// Login
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->middleware('auth:sanctum');

// Forgot password

// Perusahaan
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/perusahaan', [App\Http\Controllers\PerusahaanController::class, 'index']);
    Route::post('/perusahaan', [App\Http\Controllers\PerusahaanController::class, 'update']);
});

// Departemen
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/departemen', [App\Http\Controllers\DepartemenController::class, 'index']);
    Route::post('/departemen', [App\Http\Controllers\DepartemenController::class, 'store']);
    Route::put('/departemen/{id}', [App\Http\Controllers\DepartemenController::class, 'update']);
    Route::delete('/departemen/{id}', [App\Http\Controllers\DepartemenController::class, 'destroy']);
});

// Jabatan
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/jabatan', [App\Http\Controllers\JabatanController::class, 'index']);
    Route::post('/jabatan', [App\Http\Controllers\JabatanController::class, 'store']);
    Route::put('/jabatan/{id}', [App\Http\Controllers\JabatanController::class, 'update']);
    Route::delete('/jabatan/{id}', [App\Http\Controllers\JabatanController::class, 'destroy']);
});

// Pegawai
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index']);
    Route::post('/pegawai', [App\Http\Controllers\PegawaiController::class, 'store']);
    Route::put('/pegawai/{id}', [App\Http\Controllers\PegawaiController::class, 'update']);
    Route::delete('/pegawai/{id}', [App\Http\Controllers\PegawaiController::class, 'destroy']);
});

// Pengumuman
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/pengumuman', [App\Http\Controllers\PengumumanController::class, 'index']);
    Route::post('/pengumuman', [App\Http\Controllers\PengumumanController::class, 'store']);
    Route::get('/pengumuman/{id}', [App\Http\Controllers\PengumumanController::class, 'show']);
    Route::put('/pengumuman/{id}', [App\Http\Controllers\PengumumanController::class, 'update']);
    Route::delete('/pengumuman/{id}', [App\Http\Controllers\PengumumanController::class, 'destroy']);
});

// Kehadiran
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/kehadiran', [App\Http\Controllers\KehadiranController::class, 'index']);
    Route::get('/kehadiran/{id}', [App\Http\Controllers\KehadiranController::class, 'show']);
    Route::delete('/kehadiran/{id}', [App\Http\Controllers\KehadiranController::class, 'destroy']);
});

// E-Book
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/e-book', [App\Http\Controllers\EBookController::class, 'index']);
    Route::post('/e-book', [App\Http\Controllers\EBookController::class, 'store']);
    Route::get('/e-book/{id}', [App\Http\Controllers\EBookController::class, 'show']);
    Route::put('/e-book/{id}', [App\Http\Controllers\EBookController::class, 'update']);
    Route::delete('/e-book/{id}', [App\Http\Controllers\EBookController::class, 'destroy']);
});

// Kursus
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/kursus', [App\Http\Controllers\KursusController::class, 'index']);
    Route::post('/kursus', [App\Http\Controllers\KursusController::class, 'store']);
    Route::get('/kursus/{id}', [App\Http\Controllers\KursusController::class, 'show']);
    Route::put('/kursus/{id}', [App\Http\Controllers\KursusController::class, 'update']);
    Route::delete('/kursus/{id}', [App\Http\Controllers\KursusController::class, 'destroy']);
});

// Kategori Kursus
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/kategori-kursus', [App\Http\Controllers\KategoriKursusController::class, 'index']);
    Route::post('/kategori-kursus', [App\Http\Controllers\KategoriKursusController::class, 'store']);
    Route::get('/kategori-kursus/{id}', [App\Http\Controllers\KategoriKursusController::class, 'show']);
    Route::put('/kategori-kursus/{id}', [App\Http\Controllers\KategoriKursusController::class, 'update']);
    Route::delete('/kategori-kursus/{id}', [App\Http\Controllers\KategoriKursusController::class, 'destroy']);
});

/* Akses Pegawai */

// Login
Route::post('/pegawai/login', [App\Http\Controllers\Auth\PegawaiAuthController::class, 'login'])->name('pegawai.login');

// Logout
Route::post('/pegawai/logout', [App\Http\Controllers\Auth\PegawaiAuthController::class, 'logout'])->middleware('auth:sanctum');

// Profil Pegawai
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/pegawai/profil', [App\Http\Controllers\ProfilPegawaiController::class, 'index']);
    Route::post('/pegawai/profil', [App\Http\Controllers\ProfilPegawaiController::class, 'update']);
    Route::post('/pegawai/profil/password', [App\Http\Controllers\ProfilPegawaiController::class, 'updatePassword']);
});

// Kursus Pegawai
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/pegawai/kursus', [App\Http\Controllers\KursusPegawaiController::class, 'index']);
    Route::get('/pegawai/kursus/{id}', [App\Http\Controllers\KursusPegawaiController::class, 'show']);
});

// E-Book Pegawai
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/pegawai/e-book', [App\Http\Controllers\EBookPegawaiController::class, 'index']);
    Route::get('/pegawai/e-book/{id}', [App\Http\Controllers\EBookPegawaiController::class, 'show']);
});


/* Akses Admin */

// Login Admin
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'login'])->name('admin.login');

// Logout Admin
Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminAuthController::class, 'logout'])->middleware('auth:sanctum');

// Admin Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/admin', [App\Http\Controllers\AdminController::class, 'index']);
    Route::post('/admin/admin', [App\Http\Controllers\AdminController::class, 'store']);
    Route::get('/admin/admin/{id}', [App\Http\Controllers\AdminController::class, 'show']);
    Route::put('/admin/admin/{id}', [App\Http\Controllers\AdminController::class, 'update']);
    Route::delete('/admin/admin/{id}', [App\Http\Controllers\AdminController::class, 'destroy']);
});

// Referral
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/referral', [App\Http\Controllers\ReferralController::class, 'index']);
    Route::post('/admin/referral', [App\Http\Controllers\ReferralController::class, 'store']);
    Route::get('/admin/referral/{id}', [App\Http\Controllers\ReferralController::class, 'show']);
    Route::put('/admin/referral/{id}', [App\Http\Controllers\ReferralController::class, 'update']);
    Route::delete('/admin/referral/{id}', [App\Http\Controllers\ReferralController::class, 'destroy']);
});

// Profil Admin
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/profil', [App\Http\Controllers\ProfilAdminController::class, 'index']);
    Route::post('/admin/profil', [App\Http\Controllers\ProfilAdminController::class, 'update']);
    Route::post('/admin/profil/password', [App\Http\Controllers\ProfilAdminController::class, 'updatePassword']);
});

// Profil Perusahaan
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/perusahaan', [App\Http\Controllers\PerusahaanAdminController::class, 'index']);
    Route::get('/admin/perusahaan/{id}', [App\Http\Controllers\PerusahaanAdminController::class, 'show']);
    Route::put('/admin/perusahaan/{id}', [App\Http\Controllers\PerusahaanAdminController::class, 'update']);
    Route::delete('/admin/profil/{id}', [App\Http\Controllers\PerusahaanAdminController::class, 'destroy']);
});

// Profil Pegawai

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/pegawai/{id_perusahaan}', [App\Http\Controllers\PegawaiAdminController::class, 'index']);
    Route::get('/admin/pegawai/{id_perusahaan}/{id}', [App\Http\Controllers\PegawaiAdminController::class, 'show']);
    Route::put('/admin/pegawai/{id_perusahaan}/{id}', [App\Http\Controllers\PegawaiAdminController::class, 'update']);
    Route::delete('/admin/pegawai/{id_perusahaan}/{id}', [App\Http\Controllers\PegawaiAdminController::class, 'destroy']);
});
