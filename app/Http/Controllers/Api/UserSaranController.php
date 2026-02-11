<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KritikSaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSaranController extends Controller
{
    /**
     * Menampilkan daftar kritik & saran MILIK USER yang login
     */
    public function index()
    {
        $saran = KritikSaran::where('id_user', Auth::id())
            ->select('id', 'isi', 'created_at')   // hanya field yang perlu di mobile
            ->latest()
            ->paginate(10);  // pakai paginate biar scalable (bisa infinite scroll)

        return response()->json([
            'success' => true,
            'message' => 'Daftar kritik & saran Anda',
            'data'    => $saran,   // langsung objek paginator (seperti controller sebelumnya)
        ], 200);
    }

    /**
     * Menyimpan kritik/saran baru dari user yang login
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isi' => 'required|string|min:10|max:1000',  // minimal 10 huruf biar ga kosong2an
        ]);

        // Optional: cek apakah user sudah kirim terlalu banyak dalam waktu singkat (anti-spam sederhana)
        $recent = KritikSaran::where('id_user', Auth::id())
            ->where('created_at', '>', now()->subMinutes(5))
            ->count();
        if ($recent >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan. Coba lagi nanti.'
            ], 429);
        }

        $saran = KritikSaran::create([
            'id_user' => Auth::id(),
            'isi'     => $validated['isi'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kritik & saran berhasil dikirim. Terima kasih atas masukannya!',
            'data'    => $saran->only(['id', 'isi', 'created_at'])
        ], 201);
    }
}