<?php

use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserDashboardController;
use App\Http\Controllers\Api\UserKegiatanController;
use App\Http\Controllers\Api\UserKeluhanController;
use App\Http\Controllers\Api\UserPembayaranController;
use App\Http\Controllers\Api\UserPengumumanController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\UserSaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// login & logout
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// semua route yang butuh token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', [UserDashboardController::class, 'index']);
    Route::post('/pembayaran', [UserDashboardController::class, 'store']);

    Route::get('/pengumuman', [UserPengumumanController::class, 'index']);
    Route::get('/pengumuman/{id}', [UserPengumumanController::class, 'show']);

    Route::get('/kegiatan', [UserKegiatanController::class, 'index']);
    Route::get('/kegiatan/{id}', [UserKegiatanController::class, 'show']);

    Route::get('/profile', [UserProfileController::class, 'index']);

    Route::get('/saran', [UserSaranController::class, 'index']);
    Route::post('/saran', [UserSaranController::class, 'store']);

    Route::get('/keluhan', [UserKeluhanController::class, 'index']);           // daftar keluhan
    Route::post('/keluhan', [UserKeluhanController::class, 'store']);          // kirim keluhan
    Route::get('/keluhan/replies', [UserKeluhanController::class, 'replies']); // semua balasan
    Route::get('/keluhan/{keluhan_id}/replies', [UserKeluhanController::class, 'showReplies']);

    Route::get('/pembayaran', [UserPembayaranController::class, 'index']);
    Route::get('/pembayaran/riwayat', [UserPembayaranController::class, 'riwayat']);
    Route::post('/pembayaran/midtrans', [MidtransController::class, 'createSnapToken']);
    Route::get('/pembayaran/{id}', [UserPembayaranController::class, 'detail']);
});
