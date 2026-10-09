<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisDokumen;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    // Halaman filter dan pratinjau rekap data
    public function index(Request $request)
    {
        $jenisDokumens = JenisDokumen::all();
        $query = $this->buildFilterQuery($request);

        $pengajuans = (clone $query)->latest()->paginate(15)->withQueryString();
        $totalData = (clone $query)->count();
        $totalSelesai = (clone $query)->where('status', 'selesai')->count();
        $totalDitolak = (clone $query)->where('status', 'ditolak')->count();

        return view('admin.laporan.index', compact(
            'pengajuans',
            'jenisDokumens',
            'totalData',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    // Tampilan cetak PDF siap print dengan format Kop Surat resmi
    public function cetak(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $pengajuans = $query->latest()->get();

        $tglMulai = $request->tgl_mulai;
        $tglSelesai = $request->tgl_selesai;

        return view('admin.laporan.cetak', compact('pengajuans', 'tglMulai', 'tglSelesai'));
    }

    // Export langsung ke file Excel (CSV kompatibel Excel) tanpa package Composer
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = $this->buildFilterQuery($request);
        $data = $query->latest()->get();

        $fileName = 'Rekap_Pengajuan_Dokumen_' . date('Ymd_His') . '.csv';

        return response()->stream(function () use ($data) {
            $handle = fopen('php://output', 'w');

            // Tambahkan UTF-8 BOM agar terbaca rapi saat dibuka di Microsoft Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Baris Header Excel
            fputcsv($handle, [
                'No',
                'Nomor Tiket',
                'Tanggal Masuk',
                'Nama Siswa',
                'NIS',
                'Jenis Dokumen',
                'Perihal',
                'Status Akhir',
                'Catatan TU',
            ], ';');

            $no = 1;
            foreach ($data as $item) {
                fputcsv($handle, [
                    $no++,
                    '#MADOK-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
                    $item->tanggal_pengajuan->format('d/m/Y H:i'),
                    $item->user->name,
                    $item->user->nis_nip ?? '-',
                    $item->jenisDokumen->nama_dokumen,
                    $item->judul,
                    ucfirst($item->status),
                    $item->catatan_admin ?? '-',
                ], ';');
            }

            fclose($handle);
        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    // Logika pembangun filter bersama
    private function buildFilterQuery(Request $request)
    {
        return Pengajuan::with(['user', 'jenisDokumen'])
            ->when($request->filled('tgl_mulai'), function ($q) use ($request) {
                $q->whereDate('tanggal_pengajuan', '>=', $request->tgl_mulai);
            })
            ->when($request->filled('tgl_selesai'), function ($q) use ($request) {
                $q->whereDate('tanggal_pengajuan', '<=', $request->tgl_selesai);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('jenis_dokumen_id'), function ($q) use ($request) {
                $q->where('jenis_dokumen_id', $request->jenis_dokumen_id);
            });
    }
}