<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('biaya_settings', function (Blueprint $table) {
            $table->string('periode')->nullable()->after('id'); // format: 2026-03
            $table->unsignedTinyInteger('bulan')->nullable();
            $table->unsignedSmallInteger('tahun')->nullable();
            
            // Agar tidak duplikat periode
            $table->unique('periode');
        });
    }

    public function down()
    {
        Schema::table('biaya_settings', function (Blueprint $table) {
            $table->dropUnique(['periode']);
            $table->dropColumn(['periode', 'bulan', 'tahun']);
        });
    }
};