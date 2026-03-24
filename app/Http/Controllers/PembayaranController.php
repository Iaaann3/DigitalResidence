<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\BiayaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search');
        $status  = $request->get('status');

        if (auth()->guard('admin')->check()) {
            $query = Pembayaran::with('user', 'dibayar.rekening');

            if ($request->filled('search')) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('no_rumah', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $status);
            }
        } else {
            $query = Pembayaran::with('user', 'dibayar')
                ->where('id_user', auth()->id());

            if ($request->filled('search')) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('no_rumah', 'like', "%{$search}%");
                });
            }
        }

        $data = $query->latest()->paginate($perPage)->appends($request->all());
        return view('admin.pembayaran.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pembayaran.create');
    }

    public function store(Request $request)
    {
        $now = now();

        // Ambil BiayaSetting untuk bulan ini
        $biaya = BiayaSetting::where('tahun', $now->year)
                             ->where('bulan', $now->month)
                             ->first();

        if (!$biaya) {
            return redirect()->back()->with('error', 
                "Biaya Setting untuk bulan {$now->format('F Y')} belum diatur. 
                 Silakan atur terlebih dahulu di menu Biaya Setting.");
        }

        $created = 0;
        $skipped = 0;

        if ($request->has('id_user') && $request->id_user) {
            // Buat untuk user tertentu (termasuk user baru)
            $exists = Pembayaran::where('id_user', $request->id_user)
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->exists();

            if (!$exists) {
                Pembayaran::create([
                    'id_user'             => $request->id_user,
                    'keamanan'            => $biaya->keamanan,
                    'kebersihan'          => $biaya->kebersihan,
                    'tanggal'             => $now,
                    'tanggal_jatuh_tempo' => $biaya->tanggal_jatuh_tempo,
                    'status'              => 'belum terbayar',
                    'total'               => $biaya->keamanan + $biaya->kebersihan,
                ]);
                $created = 1;
            } else {
                $skipped = 1;
            }
        } else {
            // Buat massal untuk semua user
            $users = \App\Models\User::all();

            foreach ($users as $user) {
                $exists = Pembayaran::where('id_user', $user->id)
                    ->whereMonth('tanggal', $now->month)
                    ->whereYear('tanggal', $now->year)
                    ->exists();

                if (!$exists) {
                    Pembayaran::create([
                        'id_user'             => $user->id,
                        'keamanan'            => $biaya->keamanan,
                        'kebersihan'          => $biaya->kebersihan,
                        'tanggal'             => $now,
                        'tanggal_jatuh_tempo' => $biaya->tanggal_jatuh_tempo,
                        'status'              => 'belum terbayar',
                        'total'               => $biaya->keamanan + $biaya->kebersihan,
                    ]);
                    $created++;
                } else {
                    $skipped++;
                }
            }
        }

        $message = "Berhasil membuat {$created} tagihan IPL untuk bulan {$now->format('F Y')}.";
        if ($skipped > 0) {
            $message .= " {$skipped} user sudah memiliki tagihan di bulan ini.";
        }

        return redirect()->route('admin.pembayaran.index')->with('success', $message);
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::with('dibayar')->findOrFail($id);

        $user = auth()->user();
        $admin = auth()->guard('admin')->user();

        if (!$admin && $pembayaran->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('admin.pembayaran.edit', compact('pembayaran'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('dibayar')->findOrFail($id);

        $user = auth()->user();
        $admin = auth()->guard('admin')->user();

        if (!$admin && $pembayaran->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:belum terbayar,pembayaran berhasil',
        ]);

        $pembayaran->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroyPembayaran($id)
    {
        $pembayaran = Pembayaran::with('dibayar')->findOrFail($id);

        $user = auth()->user();
        $admin = auth()->guard('admin')->user();

        if (!$admin && $pembayaran->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($pembayaran) {
            if ($pembayaran->dibayar && $pembayaran->dibayar->foto) {
                Storage::disk('public')->delete($pembayaran->dibayar->foto);
                $pembayaran->dibayar->delete();
            }
            $pembayaran->delete();
        });

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function destroyDibayar($id)
    {
        $pembayaran = Pembayaran::with('dibayar')->findOrFail($id);

        $user = auth()->user();
        $admin = auth()->guard('admin')->user();

        if (!$admin && $pembayaran->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($pembayaran) {
            if ($pembayaran->dibayar) {
                if ($pembayaran->dibayar->foto) {
                    Storage::disk('public')->delete($pembayaran->dibayar->foto);
                }
                $pembayaran->dibayar->delete();

                // Reset status
                $pembayaran->update(['status' => 'belum terbayar']);
            }
        });

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Bukti pembayaran berhasil dihapus.');
    }

    public function generate(Request $request)
    {
        $now = now();

        $biaya = BiayaSetting::where('tahun', $now->year)
                             ->where('bulan', $now->month)
                             ->first();

        if (!$biaya) {
            return redirect()->back()->with('error', 
                "Biaya Setting untuk bulan {$now->format('F Y')} belum diatur. 
                 Silakan atur terlebih dahulu di menu Biaya Setting.");
        }

        $created = 0;

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $exists = Pembayaran::where('id_user', $user->id)
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->exists();

            if (!$exists) {
                Pembayaran::create([
                    'id_user'             => $user->id,
                    'keamanan'            => $biaya->keamanan,
                    'kebersihan'          => $biaya->kebersihan,
                    'tanggal'             => $now,
                    'tanggal_jatuh_tempo' => $biaya->tanggal_jatuh_tempo,
                    'status'              => 'belum terbayar',
                    'total'               => $biaya->keamanan + $biaya->kebersihan,
                ]);
                $created++;
            }
        }

        return redirect()->route('admin.pembayaran.index')
            ->with('success', "Berhasil membuat {$created} tagihan IPL untuk bulan {$now->format('F Y')}.");
    }
}