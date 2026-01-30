<?php
namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KeluhanReply;

class KeluhanController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluhan::with('user');

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $keluhans = $query->latest()->paginate(10);
        return view('admin.keluhan.index', compact('keluhans'));
    }

    public function show(Keluhan $keluhan)
    {
        // PERBAIKI: Load balasan dan admin
        $keluhan->load([
            'user',
            'balasan.admin:id,username' // PASTIKAN: balasan bukan replies
        ]);
        
        return view('admin.keluhan.show', compact('keluhan'));
    }

    public function updateStatus(Request $request, Keluhan $keluhan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $oldStatus = $keluhan->status;
        $keluhan->update(['status' => $request->status]);

        return redirect()->route('admin.keluhan.show', $keluhan)
            ->with('success', "Status keluhan diupdate dari '$oldStatus' ke '{$request->status}'!");
    }

    public function destroy(Keluhan $keluhan)
    {
        if ($keluhan->photos) {
            foreach ($keluhan->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $keluhan->delete();
        return redirect()->route('admin.keluhan.index')->with('success', 'Keluhan dihapus!');
    }

    public function reply(Request $request, Keluhan $keluhan)
    {
        try {
            $request->validate([
                'pesan'    => 'required|string|max:2000',
                'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // PASTIKAN menggunakan guard admin
            $adminId = auth()->guard('admin')->id();
            
            if (!$adminId) {
                throw new \Exception('Admin tidak terautentikasi. Silakan login ulang.');
            }

            // PERBAIKI: Gunakan model langsung, jangan pakai $keluhan->replies()
            $reply = KeluhanReply::create([
                'keluhan_id' => $keluhan->id,
                'admin_id' => $adminId,
                'pesan' => $request->pesan,
            ]);

            if ($request->hasFile('photos')) {
                $photos = [];
                foreach ($request->file('photos') as $file) {
                    $path = $file->store("keluhan-replies/{$keluhan->id}", 'public');
                    $photos[] = $path;
                }
                $reply->update(['photos' => $photos]);
            }

            // Update status keluhan otomatis
            if ($keluhan->status === 'pending') {
                $keluhan->update(['status' => 'diproses']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim!',
                'reply_id' => $reply->id
            ]);

        } catch (\Exception $e) {
            \Log::error('KeluhanController reply error:', [
                'keluhan_id' => $keluhan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim balasan: ' . $e->getMessage()
            ], 500);
        }
    }
}