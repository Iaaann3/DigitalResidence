<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\BiayaSettingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserKegiatanController;
use App\Http\Controllers\UserPembayaranController;
use App\Http\Controllers\UserPengumumanController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserBaruController;
use App\Http\Controllers\UserSaranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ================= HOME ROUTE =================
Route::get('/', function () {
    // Cek admin dulu
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.pembayaran.index');
    }
    // Cek user biasa
    if (Auth::guard('web')->check()) {
        return redirect()->route('user.dashboard');
    }
    // Belum login sama sekali
    return redirect()->route('login');
});

// ================= AUTH ROUTES =================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================= GOOGLE AUTH ROUTES =================
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->middleware('web');

// ================= DEBUG ROUTES (Hapus setelah fix) =================
Route::get('/debug/session', function() {
    if (!app()->environment('local')) {
        abort(404);
    }
    dd([
        'auth_check' => auth()->check(),
        'user' => auth()->user(),
        'user_id' => auth()->id(),
        'session_id' => session()->getId(),
        'session_all' => session()->all(),
    ]);
});

Route::get('/debug/logout', function() {
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

    
});

// ================= USER DASHBOARD ROUTES =================
Route::group([
    'prefix'     => 'user',
    'as'         => 'user.',
    'middleware' => ['auth', 'web'], 
], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [UserDashboardController::class, 'index'])->name('home.index');
    
    Route::post('/bayar', [UserDashboardController::class, 'store'])->name('bayar.store');
    Route::get('/pembayaran', [UserPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/riwayat', [UserPembayaranController::class, 'riwayat'])->name('pembayaran.riwayat');
    Route::get('/pembayaran/{id}/detail', [UserPembayaranController::class, 'detail'])->name('pembayaran.detail');
    Route::post('/pembayaran/{id}/bayar', [UserPembayaranController::class, 'bayar'])->name('pembayaran.bayar');
    
    Route::get('/kegiatan', [UserKegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{id}', [UserKegiatanController::class, 'show'])->name('kegiatan.show');
    
    Route::get('/pengumuman', [UserPengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{id}', [UserPengumumanController::class, 'show'])->name('pengumuman.show');
    
    Route::get('/my-profile', [UserProfileController::class, 'index'])->name('profile.index');
    
    Route::get('/kritik-saran', [UserSaranController::class, 'index'])->name('saran.index');
    Route::post('/kritik-saran', [UserSaranController::class, 'store'])->name('saran.store');
});