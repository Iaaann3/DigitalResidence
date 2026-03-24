<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaSetting extends Model
{
    protected $table = 'biaya_settings';
    protected $fillable = [
        'periode',
        'bulan',
        'tahun',
        'keamanan',
        'kebersihan',
        'tanggal_tagih',
        'tanggal_jatuh_tempo',
    ];

    // Helper untuk ambil setting bulan ini
    public static function getCurrent()
    {
        $now = now();
        return self::where('tahun', $now->year)
                   ->where('bulan', $now->month)
                   ->first();
    }
}