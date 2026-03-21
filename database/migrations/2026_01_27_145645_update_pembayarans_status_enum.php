<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom jadi VARCHAR
        DB::statement("ALTER TABLE pembayarans MODIFY status VARCHAR(50)");

        // Set default
        DB::statement("ALTER TABLE pembayarans ALTER status SET DEFAULT 'belum terbayar'");

        // Update data lama (opsional)
        DB::table('pembayarans')
            ->where('status', 'pending')
            ->update(['status' => 'belum terbayar']);
    }

    public function down(): void
    {
        // Balikin (opsional)
        DB::statement("ALTER TABLE pembayarans MODIFY status VARCHAR(50)");
    }
};
