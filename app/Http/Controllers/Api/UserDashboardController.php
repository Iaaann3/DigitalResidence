<?php

namespace App\Http\Controllers\Api;

use App\Models\Pembayaran;
use App\Models\Pengumuman;
use App\Models\Dibayar;
use App\Models\Iklan;
use App\Models\Rekening;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
     public function index()
    {
        $pengumuman = Pengumuman::latest()->take(5)->get();
        $iklans = Iklan::latest()->take(5)->get();
        $userId = Auth::id();

        // Ambil tagihan terakhir user ini
        $tagihan = Pembayaran::where('id_user', $userId)
            ->where('status', 'Belum Terbayar')
            ->latest('tanggal')
            ->first();

        $totalPembayaran = Pembayaran::where('id_user', $userId)->sum('total');

        return response()->json([
            'pengumuman' => $pengumuman,
            'tagihan' => $tagihan,
            'rekenings' => Rekening::all(),
            'totalPembayaran' => $totalPembayaran,
            'iklans' => $iklans,
        ]);
    }
    
    public function store(Request $request)
{
    // 1️⃣ Validasi input dasar
    $request->validate([
        'id_tagihan' => 'required|exists:pembayarans,id',
        'rekening_id' => 'required|exists:rekenings,id',
        'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // 2️⃣ Pastikan tagihan milik user login
    $pembayaran = Pembayaran::where('id', $request->id_tagihan)
        ->where('id_user', auth()->id()) // hanya boleh milik user yang login
        ->where('status', 'Belum Terbayar') // opsional: hanya yg belum terbayar
        ->firstOrFail();

    // 3️⃣ Simpan file bukti transfer jika ada
    $fotoPath = null;
    if ($request->hasFile('bukti_pembayaran')) {
        $fotoPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
    }

    // 4️⃣ Buat record Dibayar
    $dibayar = Dibayar::create([
        'id_user' => auth()->id(),
        'rekening_id' => $request->rekening_id,
        'foto' => $fotoPath,
        'pembayaran_id' => $pembayaran->id,
    ]);

    // 5️⃣ Update pembayaran dengan dibayar_id
    $pembayaran->update(['dibayar_id' => $dibayar->id]);

    return response()->json([
        'success' => true,
        'message' => 'Bukti pembayaran berhasil dikirim.',
        'data' => $dibayar
    ]);
}
}
