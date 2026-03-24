<?php
namespace App\Http\Controllers;

use App\Models\BiayaSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiayaSettingController extends Controller
{
    public function index()
    {
        $settings = BiayaSetting::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        $currentPeriod = now()->format('Y-m');

        // Tanggal tagih: tanggal 5 setiap bulan
        $tanggal_tagih = now()->setDay(5);

        // Tanggal jatuh tempo: tanggal 20 setiap bulan
        $tanggal_jatuh_tempo = now()->setDay(20);

        return view('admin.biaya_setting.index', compact('settings', 'currentPeriod', 'tanggal_tagih', 'tanggal_jatuh_tempo'));
    }

    public function create()
    {
        $now = now();

        // Cek apakah bulan ini sudah ada setting
        $alreadyExists = BiayaSetting::where('tahun', $now->year)
            ->where('bulan', $now->month)
            ->exists();

        if ($alreadyExists) {
            $setting = BiayaSetting::where('tahun', $now->year)
                ->where('bulan', $now->month)
                ->first();

            return redirect()->route('admin.biaya_setting.edit', $setting)
                ->with('info', 'Pengaturan bulan ini sudah ada. Silakan ubah nominal biaya saja.');
        }

        $tanggal_tagih       = $now->copy()->startOfMonth()->addDays(4);  // 5
        $tanggal_jatuh_tempo = $now->copy()->startOfMonth()->addDays(19); // 20

        // Kirim variabel ke blade
        return view('admin.biaya_setting.create', [
            'tanggal_tagih'       => $tanggal_tagih,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
        ]);
    }

    public function store(Request $request)
    {
        $now = now();

        $request->validate([
            'keamanan'   => 'required|integer|min:0',
            'kebersihan' => 'required|integer|min:0',
        ]);

        // Proteksi: Hanya boleh untuk bulan sekarang
        if (Carbon::create($now->year, $now->month, 1)->lt($now->startOfMonth())) {
            return redirect()->back()->with('error', 'Tidak dapat membuat pengaturan untuk bulan yang sudah lewat.');
        }

        $exists = BiayaSetting::where('tahun', $now->year)
            ->where('bulan', $now->month)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.biaya_setting.index')
                ->with('error', 'Pengaturan untuk bulan ini sudah ada.');
        }

        BiayaSetting::create([
            'periode'             => $now->format('Y-m'),
            'bulan'               => $now->month,
            'tahun'               => $now->year,
            'keamanan'            => $request->keamanan,
            'kebersihan'          => $request->kebersihan,
            'tanggal_tagih'       => $now->copy()->startOfMonth()->addDays(4),
            'tanggal_jatuh_tempo' => $now->copy()->startOfMonth()->addDays(19),
        ]);

        return redirect()->route('admin.biaya_setting.index')
            ->with('success', 'Pengaturan biaya untuk ' . $now->format('F Y') . ' berhasil dibuat.');
    }

    public function edit($id)
    {
        $setting = BiayaSetting::findOrFail($id);
        $now     = now();

        // Proteksi: Hanya boleh edit bulan sekarang
        $settingPeriod = Carbon::create($setting->tahun, $setting->bulan, 1)->startOfMonth();
        if ($settingPeriod->lt($now->startOfMonth())) {
            return redirect()->route('admin.biaya_setting.index')
                ->with('error', 'Tidak dapat mengedit pengaturan untuk bulan yang sudah lewat.');
        }

        return view('admin.biaya_setting.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = BiayaSetting::findOrFail($id);
        $now     = now();

        $settingPeriod = Carbon::create($setting->tahun, $setting->bulan, 1)->startOfMonth();
        if ($settingPeriod->lt($now->startOfMonth())) {
            return redirect()->route('admin.biaya_setting.index')
                ->with('error', 'Tidak dapat mengedit pengaturan untuk bulan yang sudah lewat.');
        }

        $request->validate([
            'keamanan'   => 'required|integer|min:0',
            'kebersihan' => 'required|integer|min:0',
        ]);

        $setting->update([
            'keamanan'   => $request->keamanan,
            'kebersihan' => $request->kebersihan,
        ]);

        return redirect()->route('admin.biaya_setting.index')
            ->with('success', 'Nominal biaya berhasil diperbarui untuk bulan ' . $now->format('F Y'));
    }
}
