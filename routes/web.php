<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BiayaSettingController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\UserBaruController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserKegiatanController;
use App\Http\Controllers\UserKeluhanController;
use App\Http\Controllers\UserPembayaranController;
use App\Http\Controllers\UserPengumumanController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSaranController;
use App\Http\Controllers\KeluhanController;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ================= HOME ROUTE =================
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.pembayaran.index');
    }
    if (Auth::guard('web')->check()) {
        return redirect()->route('user.dashboard')->with('login_success', true);
    }
    return redirect()->route('login');
});

// ================= AUTH ROUTES =================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================= GOOGLE AUTH ROUTES =================
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->middleware('web');

// ================= DEBUG ROUTES =================
Route::get('/debug/session', function () {
    if (! app()->environment('local')) {
        abort(404);
    }

    dd([
        'auth_check'  => auth()->check(),
        'user'        => auth()->user(),
        'user_id'     => auth()->id(),
        'session_id'  => session()->getId(),
        'session_all' => session()->all(),
    ]);
});

Route::get('/debug/logout', function () {
    Auth::logout();
    session()->flush();
    return redirect()->route('login')->with('status', 'Logged out for debug');
});

// ================= ADMIN LOGIN ROUTES =================
Route::get('login/admin', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('login/admin', [AdminController::class, 'login'])->name('admin.login');

// ================= ADMIN DASHBOARD ROUTES =================
Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth:admin', 'isAdmin'],
], function () {
    Route::resource('pembayaran', PembayaranController::class);
    Route::put('pembayaran/{id}', [PembayaranController::class, 'update'])->name('admin.pembayaran.update');
    Route::delete('/pembayaran/{id}/hapus-bukti', [PembayaranController::class, 'destroyDibayar'])
        ->name('pembayaran.destroyDibayar');
    Route::delete('/pembayaran/{id}/hapus', [PembayaranController::class, 'destroyPembayaran'])
        ->name('pembayaran.destroyPembayaran');
    Route::post('/pembayaran/generate', [PembayaranController::class, 'generate'])
        ->name('pembayaran.generate');
    Route::resource('biaya_setting', BiayaSettingController::class)->only(['index', 'store']);
    Route::resource('iklan', IklanController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('saran', KritikSaranController::class);
    Route::resource('rekenings', RekeningController::class);
    Route::resource('users', UserBaruController::class);

    Route::get('/keluhan', [KeluhanController::class, 'index'])->name('keluhan.index');
    Route::get('/keluhan/{keluhan}', [KeluhanController::class, 'show'])->name('keluhan.show');
    Route::patch('/keluhan/{keluhan}/status', [KeluhanController::class, 'updateStatus'])->name('keluhan.update.status');
    Route::delete('/keluhan/{keluhan}', [KeluhanController::class, 'destroy'])->name('keluhan.destroy');

    // BALASAN – PASTIIN POST & NAMA BENAR
    Route::post('/keluhan/{keluhan}/reply', [KeluhanController::class, 'reply'])->name('keluhan.reply');
});

// ================= MIDTRANS CALLBACK =================
Route::post('/midtrans/callback', [UserDashboardController::class, 'callback'])->name('midtrans.callback');

// ================= USER DASHBOARD ROUTES =================
Route::group([
    'prefix'     => 'user',
    'as'         => 'user.',
    'middleware' => ['auth', 'web'],
], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [UserDashboardController::class, 'index'])->name('home.index');

    // Manual Payment
    Route::post('/bayar', [UserDashboardController::class, 'store'])->name('bayar.store');

    // Pembayaran History
    Route::get('/pembayaran', [UserPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/riwayat', [UserPembayaranController::class, 'riwayat'])->name('pembayaran.riwayat');
    Route::get('/pembayaran/{id}/detail', [UserPembayaranController::class, 'detail'])->name('pembayaran.detail');
    Route::post('/pembayaran/{id}/bayar', [UserPembayaranController::class, 'bayar'])->name('pembayaran.bayar');

    // MIDTRANS ROUTES - FIX: pakai midtransGateway bukan payWithGateway
    Route::get('/bayar/gateway/{id}', [UserDashboardController::class, 'midtransGateway'])->name('bayar.gateway');
    Route::get('/bayar/nominal/{id}', [UserDashboardController::class, 'getNominal'])->name('bayar.nominal');
    Route::post('/update-status-tagihan', [UserDashboardController::class, 'updateStatus'])->name('update.status');

    // Kegiatan
    Route::get('/kegiatan', [UserKegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{id}', [UserKegiatanController::class, 'show'])->name('kegiatan.show');

    // Pengumuman
    Route::get('/pengumuman', [UserPengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{id}', [UserPengumumanController::class, 'show'])->name('pengumuman.show');

    // Profile
    Route::get('/my-profile', [UserProfileController::class, 'index'])->name('profile.index');
    // Edit Profile Routes
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    

    // Kritik & Saran
    Route::get('/kritik-saran', [UserSaranController::class, 'index'])->name('saran.index');
    Route::post('/kritik-saran', [UserSaranController::class, 'store'])->name('saran.store');

    // Keluhan
    Route::get('/keluhan', [UserKeluhanController::class, 'index'])->name('keluhan.index'); 
    Route::get('/keluhan/create', [UserKeluhanController::class, 'create'])->name('keluhan.create');
    Route::post('/keluhan', [UserKeluhanController::class, 'store'])->name('keluhan.store');
    Route::get('/keluhan/{keluhan}', [UserKeluhanController::class, 'show'])->name('keluhan.show');
    Route::delete('/keluhan/{keluhan}', [UserKeluhanController::class, 'destroy'])->name('keluhan.destroy');
});
