<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\BerkasPengajuan;
use App\Models\JenisDokumen;
use App\Models\Pengajuan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    // Menampilkan seluruh riwayat pengajuan siswa yang sedang login
    public function index()
    {
        $pengajuans = Pengajuan::with('jenisDokumen')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('siswa.pengajuan.index', compact('pengajuans'));
    }

    // Form buat pengajuan baru
    public function create()
    {
        $jenisDokumens = JenisDokumen::all();
        return view('siswa.pengajuan.create', compact('jenisDokumens'));
    }

    // Simpan data pengajuan beserta unggahan berkas
    public function store(Request $request)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'judul'            => 'required|string|max:150',
            'deskripsi'        => 'required|string',
            'berkas'           => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072', // Maksimal 3MB
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan tabel utama pengajuan
            $pengajuan = Pengajuan::create([
                'user_id'           => auth()->id(),
                'jenis_dokumen_id'  => $request->jenis_dokumen_id,
                'judul'             => $request->judul,
                'deskripsi'         => $request->deskripsi,
                'status'            => 'diajukan',
                'tanggal_pengajuan' => now(),
            ]);

            // 2. Unggah berkas ke direktori storage/app/public/berkas
            if ($request->hasFile('berkas')) {
                $file = $request->file('berkas');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('berkas', 'public');

                BerkasPengajuan::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_file'    => $originalName,
                    'path_file'    => $path,
                    'uploaded_at'  => now(),
                ]);
            }

            // 3. Catat audit trail status pertama
            RiwayatStatus::create([
                'pengajuan_id' => $pengajuan->id,
                'admin_id'     => null,
                'status_lama'  => 'baru',
                'status_baru'  => 'diajukan',
                'keterangan'   => 'Pengajuan berhasil dikirimkan oleh siswa.',
                'created_at'   => now(),
            ]);
        });

        return redirect()->route('siswa.pengajuan.index')
            ->with('success', 'Permohonan dokumen berhasil diajukan! Pantau statusnya secara berkala di sini.');
    }

    // Detail riwayat status dan catatan verifikasi
    public function show(Pengajuan $pengajuan)
    {
        // Pagar otorisasi: siswa hanya boleh melihat pengajuan miliknya sendiri
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403);
        }

        $pengajuan->load(['jenisDokumen', 'berkas', 'riwayatStatus.admin']);

        return view('siswa.pengajuan.show', compact('pengajuan'));
    }
}