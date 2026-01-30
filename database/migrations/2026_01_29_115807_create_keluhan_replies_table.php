<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu apakah table sudah ada
        if (!Schema::hasTable('keluhan_replies')) {
            Schema::create('keluhan_replies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('keluhan_id')
                      ->constrained('keluhans')
                      ->onDelete('cascade');
                      
                $table->foreignId('admin_id')
                      ->nullable()
                      ->constrained('admins')  // PASTIKAN: admins, bukan users
                      ->onDelete('set null');
                      
                $table->text('pesan');
                $table->json('photos')->nullable();
                $table->timestamps();
                
                // Index untuk performa
                $table->index('keluhan_id');
                $table->index('admin_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('keluhan_replies');
    }
};