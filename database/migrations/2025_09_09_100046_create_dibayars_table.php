<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dibayars', function (Blueprint $table) {  // Hapus duplikasi Schema::create!
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('rekening_id')->nullable()->constrained('rekenings')->onDelete('cascade');
            $table->string('foto')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['menunggu', 'lunas', 'gagal'])->default('menunggu');
            $table->unsignedBigInteger('pembayaran_id')->nullable();  // ID dari pembayarans, tanpa constraint dulu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dibayars');
    }
};