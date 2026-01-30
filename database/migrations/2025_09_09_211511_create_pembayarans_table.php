<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->integer('keamanan')->default(0);
            $table->integer('kebersihan')->default(0);
            $table->date('tanggal'); // tanggal dibuatnya pembayaran
            $table->date('tanggal_tagih')->nullable(); // tanggal mulai ditagihkan
            $table->date('tanggal_jatuh_tempo')->nullable(); // batas akhir pembayaran
            $table->enum('status', ['belum terbayar', 'pembayaran berhasil'])->default('belum terbayar');
            $table->unsignedBigInteger('dibayar_id')->nullable(); // Tanpa constrained dulu, biar gak error
            $table->string('order_id')->nullable();
            $table->integer('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};