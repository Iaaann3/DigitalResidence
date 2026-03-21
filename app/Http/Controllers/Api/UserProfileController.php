<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Mengambil data profil user yang sedang login
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

        // Hitung relasi (jika relasi sudah didefinisikan di model User)
        $iklanCount   = $user->iklan()->count();
        $kritikCount  = $user->kritikSaran()->count();

        return response()->json([
            'success' => true,
            'message' => 'Profil user berhasil diambil',
            'data'    => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'no_rumah'            => $user->no_rumah,
                'no_tlp'              => $user->no_tlp,
                'alamat'              => $user->alamat,
                'email'               => $user->email,
                'role'                => $user->role,
                'profile_photo_path'  => $user->profile_photo_path 
                    ? url('storage/' . $user->profile_photo_path)  
                    : null,
                'created_at'          => $user->created_at->toDateTimeString(),
                'iklan_count'         => $iklanCount,
                'kritik_count'        => $kritikCount,
            ]
        ]);
    }
}