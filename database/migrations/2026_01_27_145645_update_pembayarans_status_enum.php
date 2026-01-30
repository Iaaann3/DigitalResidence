<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing enum constraint kalau ada (aman, gak hapus data)
        DB::statement("ALTER TABLE pembayarans DROP CONSTRAINT IF EXISTS pembayarans_status_check");

        // Ubah column status ke string (varchar) dengan check constraint manual
        DB::statement("ALTER TABLE pembayarans ALTER COLUMN status TYPE VARCHAR(50) USING status::VARCHAR(50)");

        // Tambah check constraint untuk validasi enum-like
        DB::statement("ALTER TABLE pembayarans ADD CONSTRAINT pembayarans_status_check CHECK (status IN ('belum terbayar', 'menunggu verifikasi', 'pembayaran berhasil', 'gagal'))");

        // Set default baru (kalau perlu)
        DB::statement("ALTER TABLE pembayarans ALTER COLUMN status SET DEFAULT 'belum terbayar'");

        // Update existing data kalau ada yang gak match (opsional, sesuaikan)
        DB::table('pembayarans')
            ->where('status', 'pending')  // Kalau ada old value
            ->update(['status' => 'belum terbayar']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: Drop check, ubah balik ke enum original (sesuaikan dengan migration awal)
        DB::statement("ALTER TABLE pembayarans DROP CONSTRAINT IF EXISTS pembayarans_status_check");
        DB::statement("ALTER TABLE pembayarans ALTER COLUMN status TYPE VARCHAR(50)");  // Atau sesuaikan ke enum lama
        // Kalau mau enum asli, tambah: DB::statement("ALTER TABLE pembayarans ADD COLUMN status VARCHAR(50) CHECK (status IN ('belum terbayar', 'pembayaran berhasil'))");
    }
};