<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;  // Tambah buat debug

class UserKeluhanController extends Controller
{
    public function index()
    {
        $keluhans = Auth::user()->keluhans()->latest()->paginate(10);
        return view('users.keluhan.index', compact('keluhans'));  // Pastiin 'users' plural
    }

    public function create()
    {
        return view('users.keluhan.create');  // FIX: 'users' plural, match folder
    }

    public function store(Request $request)
    {
        try {
            Log::info('Keluhan store started', ['user_id' => Auth::id()]);  // Debug log

            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string|max:1000',
                'photos' => 'nullable|array|max:10',
                'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $photosPath = [];

            if ($request->hasFile('photos')) {
                Log::info('Photos received', ['count' => count($request->file('photos'))]);  // Debug
                foreach ($request->file('photos') as $photo) {
                    if ($photo->isValid()) {
                        $path = $photo->store('keluhan-photos', 'public');
                        $photosPath[] = $path;
                        Log::info('Photo uploaded', ['path' => $path]);  // Debug
                    }
                }
            }

            $keluhan = Keluhan::create([
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'isi' => $request->isi,
                'photos' => $photosPath,
                'status' => 'pending',
            ]);

            Log::info('Keluhan created', ['id' => $keluhan->id]);  // Debug

            return response()->json([
                'success' => true,
                'message' => 'Keluhan berhasil dikirim beserta ' . count($photosPath) . ' foto!',
                'redirect' => route('user.keluhan.index')  // FIX: 'user.keluhan.index' (singular dari prefix)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in store', $e->errors());  // Log error
            return response()->json([
                'success' => false,
                'message' => 'Validasi error: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Keluhan store error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);  // Log full error
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Keluhan $keluhan)
    {
        if ($keluhan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        return view('users.keluhan.show', compact('keluhan'));  // FIX: 'users' plural
    }

    public function destroy(Keluhan $keluhan)
    {
        if ($keluhan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($keluhan->photos) {
            foreach ($keluhan->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $keluhan->delete();
        return redirect()->route('user.keluhan.index')->with('success', 'Keluhan dihapus!');  // FIX: Route name singular
    }
}