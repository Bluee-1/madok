<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Seeder;

class JenisDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $dokumen = [
            [
                'nama_dokumen' => 'Surat Keterangan Siswa Aktif',
                'kategori'     => 'Surat Keterangan',
                'deskripsi'    => 'Surat resmi keterangan aktif sekolah untuk keperluan tunjangan gaji orang tua, beasiswa, atau instansi luar.',
            ],
            [
                'nama_dokumen' => 'Surat Keterangan Kelakuan Baik',
                'kategori'     => 'Surat Keterangan',
                'deskripsi'    => 'Keterangan berkelakuan baik dari pihak sekolah untuk pendaftaran lomba, beasiswa, atau mutasi.',
            ],
            [
                'nama_dokumen' => 'Legalisir Rapor / Ijazah',
                'kategori'     => 'Legalisir',
                'deskripsi'    => 'Permohonan pengesahan fotokopi rapor semester atau ijazah kelulusan oleh kepala sekolah/pejabat berwenang.',
            ],
            [
                'nama_dokumen' => 'Pengaduan Dokumen Hilang',
                'kategori'     => 'Pengaduan',
                'deskripsi'    => 'Laporan kehilangan kartu pelajar, lembar rapor, atau sertifikat akademik untuk permohonan penerbitan surat pengganti.',
            ],
            [
                'nama_dokumen' => 'Pengaduan Dokumen Rusak',
                'kategori'     => 'Pengaduan',
                'deskripsi'    => 'Laporan fisik dokumen akademik yang basah, sobek, atau tidak terbaca untuk validasi pencetakan ulang.',
            ],
        ];

        foreach ($dokumen as $item) {
            JenisDokumen::updateOrCreate(
                ['nama_dokumen' => $item['nama_dokumen']],
                $item
            );
        }
    }
}