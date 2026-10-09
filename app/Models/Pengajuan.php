<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id',
        'jenis_dokumen_id',
        'judul',
        'deskripsi',
        'status',
        'catatan_admin',
        'tanggal_pengajuan',
        'tanggal_diproses',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_diproses' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPengajuan::class);
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class)->latest('created_at');
    }
}