<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengajuan Dokumen Akademik — MADOK</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #111;
            margin: 20px;
            font-size: 12pt;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .kop-surat h3 {
            margin: 2px 0;
            font-size: 13pt;
            font-weight: normal;
        }
        .kop-surat p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h4 {
            margin: 0;
            text-decoration: underline;
            font-size: 13pt;
        }
        .judul-laporan p {
            margin: 4px 0 0 0;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px 4px;
            text-align: center;
        }
        td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .text-center { text-align: center; }
        .ttd-wrapper {
            margin-top: 40px;
            float: right;
            width: 250px;
            text-align: center;
            font-size: 11pt;
        }
        .ttd-space { height: 70px; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <!-- Tombol Khusus Layar Sebelum Cetak -->
    <div class="no-print" style="background: #fdf6b2; padding: 12px; margin-bottom: 20px; border-radius: 6px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #1f2937; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            🖨 Klik untuk Cetak / Simpan ke PDF
        </button>
    </div>

    <!-- Kop Surat Resmi Sekolah -->
    <div class="kop-surat">
        <h2>SMK NEGERI CONTOH KOTA</h2>
        <h3>BAGIAN ADMINISTRASI & TATA USAHA (TU)</h3>
        <p>Jalan Pendidikan No. 123, Telp. (0271) 712345, Email: tu@smknegeri.sch.id</p>
    </div>

    <!-- Judul Laporan -->
    <div class="judul-laporan">
        <h4>REKAPITULASI PENGAJUAN DOKUMEN AKADEMIK</h4>
        <p>
            Periode: 
            {{ $tglMulai ? \Carbon\Carbon::parse($tglMulai)->format('d/m/Y') : 'Awal' }} 
            s/d 
            {{ $tglSelesai ? \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y') : 'Hari Ini' }}
        </p>
    </div>

    <!-- Tabel Data Rekap -->
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 22%;">Nama Siswa / NIS</th>
                <th style="width: 20%;">Layanan Dokumen</th>
                <th style="width: 27%;">Perihal</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->user->name }}</strong><br>
                        <small>NIS: {{ $item->user->nis_nip ?? '-' }}</small>
                    </td>
                    <td>{{ $item->jenisDokumen->nama_dokumen }}</td>
                    <td>{{ $item->judul }}</td>
                    <td class="text-center uppercase" style="font-weight: bold;">{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data permohonan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Bagian Tanda Tangan Pengesahan -->
    <div class="ttd-wrapper">
        <p>Surakarta, {{ date('d F Y') }}<br>Kepala Tata Usaha,</p>
        <div class="ttd-space"></div>
        <p style="text-decoration: underline; font-weight: bold; margin: 0;">Drs. H. Administrator, M.Pd.</p>
        <p style="margin: 0; font-size: 9pt;">NIP. 19800101 200501 1 002</p>
    </div>

</body>
</html>