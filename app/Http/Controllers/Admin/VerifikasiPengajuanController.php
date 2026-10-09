<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $pengajuans = Pengajuan::with(['user', 'jenisDokumen'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengajuan.index', compact('pengajuans', 'status'));
    }

    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load(['user', 'jenisDokumen', 'berkas', 'riwayatStatus.admin']);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status'        => 'required|in:diajukan,diproses,disetujui,ditolak,selesai',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $pengajuan) {
            $statusLama = $pengajuan->status;
            $statusBaru = $request->status;

            $pengajuan->update([
                'status'           => $statusBaru,
                'catatan_admin'    => $request->catatan_admin,
                'tanggal_diproses' => in_array($statusBaru, ['diproses', 'disetujui', 'ditolak', 'selesai']) ? now() : $pengajuan->tanggal_diproses,
            ]);

            if ($statusLama !== $statusBaru || !empty($request->catatan_admin)) {
                RiwayatStatus::create([
                    'pengajuan_id' => $pengajuan->id,
                    'admin_id'     => auth()->id(),
                    'status_lama'  => $statusLama,
                    'status_baru'  => $statusBaru,
                    'keterangan'   => $request->catatan_admin ?? 'Status pengajuan diperbarui oleh petugas TU.',
                    'created_at'   => now(),
                ]);
            }
        });

        return redirect()->route('admin.verifikasi.show', $pengajuan->id)
            ->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}