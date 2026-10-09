<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $jenisDokumen = JenisDokumen::withCount('pengajuans')->latest()->paginate(10);
        return view('admin.jenis-dokumen.index', compact('jenisDokumen'));
    }

    public function create()
    {
        return view('admin.jenis-dokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:100',
            'kategori'     => 'required|string|max:50',
            'deskripsi'    => 'nullable|string',
        ]);

        JenisDokumen::create($validated);

        return redirect()->route('admin.jenis-dokumen.index')
            ->with('success', 'Jenis dokumen berhasil ditambahkan.');
    }

    public function edit(JenisDokumen $jenisDokumen)
    {
        return view('admin.jenis-dokumen.edit', compact('jenisDokumen'));
    }

    public function update(Request $request, JenisDokumen $jenisDokumen)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:100',
            'kategori'     => 'required|string|max:50',
            'deskripsi'    => 'nullable|string',
        ]);

        $jenisDokumen->update($validated);

        return redirect()->route('admin.jenis-dokumen.index')
            ->with('success', 'Data jenis dokumen berhasil diperbarui.');
    }

    public function destroy(JenisDokumen $jenisDokumen)
    {
        // Proteksi integritas relasi foreign key
        if ($jenisDokumen->pengajuans()->exists()) {
            return redirect()->route('admin.jenis-dokumen.index')
                ->with('error', 'Gagal menghapus: Jenis dokumen ini sudah digunakan pada riwayat pengajuan siswa.');
        }

        $jenisDokumen->delete();

        return redirect()->route('admin.jenis-dokumen.index')
            ->with('success', 'Jenis dokumen berhasil dihapus.');
    }
}