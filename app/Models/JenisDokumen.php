<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumen';

    protected $fillable = [
        'nama_dokumen',
        'kategori',
        'deskripsi',
    ];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}