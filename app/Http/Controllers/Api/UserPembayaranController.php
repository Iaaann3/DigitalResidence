<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserPembayaranController extends Controller
{
    /**
     * Menampilkan daftar semua pembayaran user yang sedang login
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan atau belum login.'
            ], 401);
        }

        $pembayarans = Pembayaran::where('id_user', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pembayaran berhasil diambil',
            'data'    => $pembayarans
        ]);
    }

    /**
     * Menampilkan riwayat pembayaran (sama dengan index, tapi bisa dikembangkan nanti)
     */
    public function riwayat(Request $request)
    {
        return $this->index($request); // reuse logic index
    }

    /**
     * Menampilkan detail satu pembayaran berdasarkan ID
     */
    public function detail(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan atau belum login.'
            ], 401);
        }

        $pembayaran = Pembayaran::where('id_user', $user->id)
            ->where('id', $id)
            ->first();

        if (!$pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan atau Anda tidak memiliki akses.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran berhasil diambil',
            'data'    => $pembayaran
        ]);
    }

    // Jika nanti kamu ingin mengaktifkan konfirmasi pembayaran via API:
    /*
    public function konfirmasi(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan atau belum login.'
            ], 401);
        }

        $pembayaran = Pembayaran::where('id', $id)
            ->where('id_user', $user->id)
            ->firstOrFail();

        // Logika konfirmasi di sini (misalnya update status)
        // $pembayaran->update([...]);

        return response()->json([
            'success' => true,
            'message' => 'Konfirmasi pembayaran berhasil',
            'data'    => $pembayaran
        ]);
    }
    */
}