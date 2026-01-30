<?php

namespace App\Http\Controllers;

use App\Models\Dibayar;
use App\Models\Iklan;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class UserDashboardController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->take(5)->get();
        $iklans = Iklan::latest()->take(5)->get();
        $userId = Auth::id();

        $tagihan = Pembayaran::where('id_user', $userId)
            ->whereIn('status', ['belum terbayar', 'gagal'])
            ->latest('tanggal')
            ->first();

        $totalPembayaran = Pembayaran::where('id_user', $userId)
            ->where('status', 'pembayaran berhasil')
            ->sum('total');

        return view('users.home.index', [
            'pengumuman' => $pengumuman,
            'tagihan' => $tagihan,
            'rekenings' => Rekening::all(),
            'totalPembayaran' => $totalPembayaran,
            'iklans' => $iklans,
            'user' => Auth::user(),
        ]);
    }

    /**
     * MANUAL PAYMENT (UPLOAD BUKTI)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tagihan' => 'required|exists:pembayarans,id',
            'rekening_id' => 'required|exists:rekenings,id',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pembayaran = Pembayaran::where('id', $request->id_tagihan)
            ->where('status', 'belum terbayar')
            ->firstOrFail();

        $fotoPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $dibayar = Dibayar::create([
            'id_user' => Auth::id(),
            'rekening_id' => $request->rekening_id,
            'foto' => $fotoPath,
            'pembayaran_id' => $pembayaran->id,
            'status' => 'menunggu verifikasi',
        ]);

        $pembayaran->update([
            'dibayar_id' => $dibayar->id,
            'status' => 'menunggu verifikasi',
        ]);

        return redirect()->route('user.home.index')->with('success', 'Bukti dikirim! Menunggu verifikasi.');
    }

    /**
     * PAYMENT GATEWAY (MIDTRANS) - Return JSON untuk AJAX
     * Method: midtransGateway (sesuai dengan route)
     */
    public function midtransGateway($id)
    {
        try {
            \Log::info('=== MIDTRANS GATEWAY START ===');
            \Log::info('User ID: ' . Auth::id());
            \Log::info('Tagihan ID: ' . $id);
            
            $pembayaran = Pembayaran::where('id', $id)
                ->where('id_user', Auth::id())
                ->whereIn('status', ['belum terbayar', 'gagal'])
                ->firstOrFail();

            \Log::info('Tagihan ditemukan:', [
                'id' => $pembayaran->id,
                'total' => $pembayaran->total,
                'status' => $pembayaran->status,
                'existing_order_id' => $pembayaran->order_id
            ]);

            // Setup Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // SELALU BUAT ORDER ID BARU untuk menghindari "order_id has already been taken"
            $orderId = 'IPL-' . $pembayaran->id . '-' . time() . '-' . rand(1000, 9999);
            
            // Update order_id di database
            $pembayaran->update(['order_id' => $orderId]);
            
            \Log::info('New Order ID generated:', ['order_id' => $orderId]);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $pembayaran->total,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email ?? 'user@example.com',
                    'phone' => Auth::user()->phone ?? '081234567890',
                ],
                'item_details' => [[
                    'id' => 'ITEM-' . $pembayaran->id . '-' . time(),
                    'price' => (int) $pembayaran->total,
                    'quantity' => 1,
                    'name' => 'Tagihan IPL ' . ($pembayaran->bulan ?? date('F')) . ' ' . ($pembayaran->tahun ?? date('Y')),
                ]],
            ];

            \Log::info('Midtrans Params:', $params);

            $snapToken = Snap::getSnapToken($params);
            
            \Log::info('Snap Token generated, length: ' . strlen($snapToken));

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Gateway Error: ' . $e->getMessage());
            
            // Cek jika error karena order_id duplicate
            if (strpos($e->getMessage(), 'order_id has already been taken') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan coba klik Bayar lagi.',
                    'retry' => true
                ], 500);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Nominal Tagihan untuk AJAX
     */
    public function getNominal($id)
    {
        try {
            $pembayaran = Pembayaran::where('id', $id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'total' => $pembayaran->total,
                'bulan' => $pembayaran->bulan,
                'tahun' => $pembayaran->tahun,
                'formatted' => 'Rp ' . number_format($pembayaran->total, 0, ',', '.')
            ]);

        } catch (\Exception $e) {
            \Log::error('Get Nominal Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update Status setelah Midtrans Success (AJAX)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pembayarans,id',
            'status' => 'required|in:pembayaran berhasil,gagal'
        ]);

        try {
            $pembayaran = Pembayaran::where('id', $request->id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $pembayaran->update([
                'status' => $request->status,
                'tanggal_bayar' => now()
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Update Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * MIDTRANS CALLBACK (Manual Parse)
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signature = hash('sha512', 
            $request->order_id . 
            $request->status_code . 
            $request->gross_amount . 
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            \Log::error('Invalid signature from Midtrans');
            return response('OK', 200);
        }

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;
        $fraud = $request->fraud_status ?? 'accept';

        $pembayaran = Pembayaran::where('order_id', $orderId)->first();
        if (!$pembayaran) {
            \Log::error('Order not found: ' . $orderId);
            return response('OK', 200);
        }

        // Update atau create Dibayar record
        Dibayar::updateOrCreate(
            ['pembayaran_id' => $pembayaran->id],
            [
                'id_user' => $pembayaran->id_user,
                'payment_type' => $request->payment_type ?? null,
                'transaction_id' => $request->transaction_id ?? null,
                'status' => $transactionStatus,
                'bank' => $request->bank ?? null,
                'va_numbers' => $request->va_numbers ? json_encode($request->va_numbers) : null,
            ]
        );

        // Update status pembayaran
        if (in_array($transactionStatus, ['capture', 'settlement']) && $fraud === 'accept') {
            $pembayaran->update([
                'status' => 'pembayaran berhasil',
                'tanggal_bayar' => now()
            ]);
        } elseif ($transactionStatus === 'pending' || $fraud === 'challenge') {
            $pembayaran->update(['status' => 'menunggu verifikasi']);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire']) || $fraud === 'reject') {
            $pembayaran->update(['status' => 'gagal']);
        }

        \Log::info('Midtrans callback processed', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'payment_id' => $pembayaran->id
        ]);

        return response('OK', 200);
    }
}