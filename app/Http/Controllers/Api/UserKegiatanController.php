<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class UserKegiatanController extends Controller
{
    /**
     * Daftar kegiatan terbaru (untuk mobile)
     */
    public function index()
    {
        $kegiatan = Kegiatan::select(
            'id',
            'nama_kegiatan',
            'deskripsi',
            'lokasi',
            'gambar',
            'tanggal',
            'created_at'
        )
        ->latest()
        ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar kegiatan',
            'data'    => $kegiatan   // ← langsung objek paginator, biar muncul semua isinya
        ], 200);
    }

    /**
     * Detail satu kegiatan
     */
    public function show($id)
    {
        $kegiatan = Kegiatan::select(
            'id',
            'nama_kegiatan',
            'deskripsi',
            'lokasi',
            'gambar',
            'tanggal',
            'created_at'
        )->find($id);

        if (!$kegiatan) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kegiatan',
            'data'    => $kegiatan
        ], 200);
    }
}