<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rekapitulasi & Laporan Pengajuan Dokumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Formulir Filter Data -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-4">Filter Periode & Kriteria</h3>
                
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}"
                            class="w-full rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Sampai</label>
                        <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}"
                            class="w-full rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status Dokumen</label>
                        <select name="status" class="w-full rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Semua Status --</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Layanan Dokumen</label>
                        <select name="jenis_dokumen_id" class="w-full rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Semua Dokumen --</option>
                            @foreach($jenisDokumens as $jd)
                                <option value="{{ $jd->id }}" {{ request('jenis_dokumen_id') == $jd->id ? 'selected' : '' }}>
                                    {{ $jd->nama_dokumen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

<div class="sm:col-span-2 md:col-span-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.laporan.index') }}" class="text-xs text-gray-500 hover:text-gray-800 underline">
                            Reset Filter
                        </a>
                        <div class="flex items-center space-x-3">
                            <button type="submit" 
                                style="background-color: #4f46e5; color: #ffffff;"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                                🔍 Terapkan Filter
                            </button>

                            <a href="{{ route('admin.laporan.cetak', request()->query()) }}" target="_blank"
                                style="background-color: #1e293b; color: #ffffff;"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                                🖨 Cetak PDF
                            </a>

                            <a href="{{ route('admin.laporan.excel', request()->query()) }}"
                                style="background-color: #059669; color: #ffffff;"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                                📊 Unduh Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Angka Rekap -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 uppercase">Total Sesuai Filter</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalData }} Pengajuan</p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-medium text-emerald-600 uppercase">Telah Selesai</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalSelesai }}</p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-medium text-rose-600 uppercase">Ditolak</p>
                    <p class="text-2xl font-bold text-rose-600 mt-1">{{ $totalDitolak }}</p>
                </div>
            </div>

            <!-- Tabel Pratinjau Rekap -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50 text-gray-500 uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Siswa / NIS</th>
                                <th class="px-4 py-3 text-left">Dokumen</th>
                                <th class="px-4 py-3 text-left">Perihal</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($pengajuans as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $pengajuans->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        {{ $item->user->name }}
                                        <span class="block text-[10px] text-gray-400 font-normal">NIS: {{ $item->user->nis_nip ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $item->jenisDokumen->nama_dokumen }}</td>
                                    <td class="px-4 py-3 max-w-xs truncate">{{ $item->judul }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full font-semibold text-[10px]
                                            @if($item->status == 'selesai') bg-emerald-100 text-emerald-800
                                            @elseif($item->status == 'ditolak') bg-rose-100 text-rose-800
                                            @else bg-amber-100 text-amber-800 @endif">
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                        Tidak ada data pengajuan dalam rentang kriteria ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pengajuans->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>