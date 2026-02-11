<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class UserPengumumanController extends Controller
{
    /**
     * Daftar pengumuman terbaru (untuk mobile)
     */
    public function index()
    {
        $pengumuman = Pengumuman::select(
            'id',
            'judul',
            'isi',
            'tanggal',
            'gambar'
        )
        ->latest()
        ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengumuman',
            'data'    => $pengumuman   // ← langsung paginator object
        ], 200);
    }

    /**
     * Detail satu pengumuman
     */
    public function show($id)
    {
        $pengumuman = Pengumuman::select(
            'id',
            'judul',
            'isi',
            'tanggal',
            'gambar',
            'created_at'
        )->find($id);

        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengumuman',
            'data'    => $pengumuman
        ], 200);
    }
}