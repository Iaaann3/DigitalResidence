<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeluhanReply extends Model
{
    protected $table = 'keluhan_replies';
    
    protected $fillable = ['keluhan_id', 'admin_id', 'pesan', 'photos'];
    protected $casts = ['photos' => 'array'];

    public function keluhan()
    {
        return $this->belongsTo(Keluhan::class, 'keluhan_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}