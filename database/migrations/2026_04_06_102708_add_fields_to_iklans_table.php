<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('iklans', function (Blueprint $table) {

        // rename biar standard (optional tapi recommended)
        // $table->renameColumn('id_user', 'user_id');

        // status iklan
        $table->enum('status', ['pending', 'approved', 'rejected'])
              ->default('pending')
              ->after('gambar');

        // aktif / nonaktif
        $table->boolean('is_active')
              ->default(true)
              ->after('status');

        // jadwal tayang
        $table->date('start_date')->nullable()->after('is_active');
        $table->date('end_date')->nullable()->after('start_date');

        // statistik
        $table->integer('views')->default(0)->after('end_date');
        $table->integer('clicks')->default(0)->after('views');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('iklans', function (Blueprint $table) {
        // $table->renameColumn('user_id', 'id_user');

        $table->dropColumn([
            'status',
            'is_active',
            'start_date',
            'end_date',
            'views',
            'clicks'
        ]);
    });
}

};
