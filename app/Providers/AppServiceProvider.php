<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Ambil nilai dari config/midtrans.php yang sudah Anda buat
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 2. Terapkan Solusi Error "SSL Handshake Failure"
        // Memaksa penggunaan TLS 1.2
        $curlOptions = [
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2
        ];

        // Opsional: Jika Anda MASIH gagal di LOCALHOST saja, buka komentar dua baris di bawah ini.
        // PERINGATAN: Hapus atau beri komentar kembali jika naik ke server Production!
        /*
        if (!config('midtrans.is_production')) {
            $curlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = 0;
        }
        */

        // Masukkan opsi cURL ke konfigurasi Midtrans
        Config::$curlOptions = $curlOptions;
    }
}
