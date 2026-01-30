<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'id_user', 'keamanan', 'kebersihan', 'tanggal', 'tanggal_tagih', 'tanggal_jatuh_tempo',
        'status', 'dibayar_id', 'order_id', 'total',
    ];

    protected $casts = [
        'tanggal'             => 'date',
        'tanggal_tagih'       => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dibayar()
    {
        return $this->belongsTo(Dibayar::class, 'dibayar_id');
    }
}
