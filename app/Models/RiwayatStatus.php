<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status';
    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'admin_id',
        'status_lama',
        'status_baru',
        'keterangan',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}