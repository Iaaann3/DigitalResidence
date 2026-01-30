<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul', 'isi', 'photos', 'status'];

    protected $casts = [
        'photos'     => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Keluhan.php
public function balasan() // Ganti dari replies() ke balasan()
{
    return $this->hasMany(KeluhanReply::class);
}
}
