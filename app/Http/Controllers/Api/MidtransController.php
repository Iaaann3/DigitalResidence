<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans Config
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Buat Snap Token untuk pembayaran
     */
    public function createSnapToken(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login',
            ], 401);
        }

        // Validasi input
        $request->validate([
            'pembayaran_id'  => 'required|integer|exists:pembayarans,id',
            'gross_amount'   => 'required|numeric|min:1000',
            'customer_name'  => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string',
        ]);

        // Cek apakah pembayaran milik user ini
        $pembayaran = \App\Models\Pembayaran::where('id', $request->pembayaran_id)
            ->where('id_user', $user->id)
            ->first();

        if (! $pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan atau bukan milik Anda',
            ], 404);
        }

        // Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . $pembayaran->id . '-' . time(),
                'gross_amount' => (int) $request->gross_amount,
            ],
            'customer_details'    => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone ?? $user->no_tlp,
            ],
            'item_details'        => [
                [
                    'id'       => $pembayaran->id,
                    'price'    => (int) $request->gross_amount,
                    'quantity' => 1,
                    'name'     => 'Pembayaran #' . $pembayaran->id,
                ],
            ],
            // Callback URL (opsional)
            'callbacks'           => [
                'finish' => url('/payment/finish'), // Halaman setelah bayar (bisa diubah)
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Optional: Simpan snap_token ke tabel pembayaran
            $pembayaran->update([
                'snap_token' => $snapToken,
                'status'     => 'menunggu verifikasi',
            ]);

            return response()->json([
                'success'      => true,
                'message'      => 'Snap token berhasil dibuat',
                'snap_token'   => $snapToken,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v1/transactions/{$snapToken}", // Untuk WebView
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat snap token: ' . $e->getMessage(),
            ], 500);
        }
    }
}
