<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use App\Models\KeluhanReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserKeluhanController extends Controller
{
    /**
     * GET /api/keluhan
     * Daftar keluhan milik user yang login (paginated)
     */
    public function index()
    {
        $keluhan = Keluhan::where('user_id', Auth::id())
            ->select('id', 'judul', 'isi', 'photos', 'status', 'created_at') // tambah photos & status biar lengkap
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar keluhan Anda',
            'data'    => $keluhan,
        ], 200);
    }

    /**
     * POST /api/keluhan
     * Kirim keluhan baru (wajib judul seperti versi web)
     */
    public function store(Request $request)
    {
        try {
            Log::info('API Keluhan store started', [
                'user_id' => Auth::id(),
                'ip'      => $request->ip(),
            ]);

            $validated = $request->validate([
                'judul'    => 'required|string|max:255',
                'isi'      => 'required|string|min:10|max:2000',
                'photos'   => 'nullable|array|max:10',
                'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $photosPath = [];

            if ($request->hasFile('photos')) {
                Log::info('Photos received', [
                    'count' => count($request->file('photos')),
                    'files' => collect($request->file('photos'))->map(fn($f) => $f->getClientOriginalName())->toArray(),
                ]);

                foreach ($request->file('photos') as $photo) {
                    if ($photo->isValid()) {
                        // Simpan dengan nama unik + original extension
                        $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                        $path     = $photo->storeAs('keluhan-photos', $filename, 'public');

                        $photosPath[] = $path; // ← RELATIVE PATH SAJA (ini yang disimpan di DB)
                        Log::info('Photo uploaded', [
                            'original_name' => $photo->getClientOriginalName(),
                            'stored_path'   => $path,
                        ]);
                    } else {
                        Log::warning('Invalid photo file skipped', [
                            'name' => $photo->getClientOriginalName(),
                        ]);
                    }
                }
            }

            $keluhan = Keluhan::create([
                'user_id' => Auth::id(),
                'judul'   => $validated['judul'],
                'isi'     => $validated['isi'],
                'photos'  => $photosPath ?: null, // array of relative paths
                'status'  => 'pending',
            ]);

            Log::info('Keluhan created successfully', [
                'id'          => $keluhan->id,
                'judul'       => $keluhan->judul,
                'photo_count' => count($photosPath),
            ]);

            // Kembalikan full URL di response untuk Flutter
            $responsePhotos = $keluhan->photos
                ? array_map(fn($p) => Storage::url($p), $keluhan->photos)
                : null;

            return response()->json([
                'success' => true,
                'message' => 'Keluhan berhasil dikirim' . (count($photosPath) > 0 ? ' beserta ' . count($photosPath) . ' foto' : ''),
                'data'    => [
                    'id'         => $keluhan->id,
                    'judul'      => $keluhan->judul,
                    'isi'        => $keluhan->isi,
                    'photos'     => $responsePhotos, // full URL untuk mobile
                    'status'     => $keluhan->status,
                    'created_at' => $keluhan->created_at->toDateTimeString(),
                ],
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in API store', [
                'errors' => $e->errors(),
                'input'  => $request->except('photos'),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('API Keluhan store error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'input'   => $request->except('photos'),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server. Silakan coba lagi nanti.',
            ], 500);
        }
    }
    /**
     * GET /api/keluhan/replies
     */
    public function replies()
    {
        $keluhans = Keluhan::where('user_id', Auth::id())
            ->with(['balasan' => function ($q) {
                $q->select('id', 'keluhan_id', 'pesan', 'photos', 'created_at')
                    ->latest();
            }])
            ->select('id', 'judul', 'isi', 'photos', 'status', 'created_at') // tambah judul, photos, status
            ->latest()
            ->get();

        $formatted = $keluhans->map(function ($keluhan) {
            return [
                'keluhan_id'      => $keluhan->id,
                'keluhan_judul'   => $keluhan->judul,
                'keluhan_isi'     => $keluhan->isi,
                'keluhan_photos'  => $keluhan->photos ?? [], // tambah foto keluhan jika ada
                'keluhan_status'  => $keluhan->status,
                'keluhan_tanggal' => $keluhan->created_at->toDateTimeString(),
                'balasan_count'   => $keluhan->balasan->count(),
                'balasan'         => $keluhan->balasan->map(function ($balasan) {
                    return [
                        'id'         => $balasan->id,
                        'pesan'      => $balasan->pesan,
                        'photos'     => $balasan->photos ?? [],
                        'created_at' => $balasan->created_at->toDateTimeString(),
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar balasan keluhan Anda',
            'data'    => $formatted,
        ], 200);
    }

    /**
     * GET /api/keluhan/{keluhan_id}/replies
     */
    public function showReplies($keluhan_id)
    {
        $keluhan = Keluhan::where('user_id', Auth::id())
            ->where('id', $keluhan_id)
            ->select('id', 'judul', 'isi', 'photos', 'status', 'created_at') // tambah judul, photos, status
            ->first();

        if (! $keluhan) {
            return response()->json([
                'success' => false,
                'message' => 'Keluhan tidak ditemukan atau bukan milik Anda',
            ], 404);
        }

        $balasan = KeluhanReply::where('keluhan_id', $keluhan_id)
            ->select('id', 'pesan', 'photos', 'created_at')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'pesan'      => $item->pesan,
                    'photos'     => $item->photos ?? [],
                    'created_at' => $item->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Balasan untuk keluhan ini',
            'data'    => [
                'keluhan' => [
                    'id'      => $keluhan->id,
                    'judul'   => $keluhan->judul, // tambah judul di sini
                    'isi'     => $keluhan->isi,
                    'photos'  => $keluhan->photos ?? [],
                    'status'  => $keluhan->status,
                    'tanggal' => $keluhan->created_at->toDateTimeString(),
                ],
                'balasan' => $balasan,
            ],
        ], 200);
    }
}
