<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPengajuan extends Model
{
    use HasFactory;

    protected $table = 'berkas_pengajuan';
    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'nama_file',
        'path_file',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}