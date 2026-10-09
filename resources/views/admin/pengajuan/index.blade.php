<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Verifikasi Pengajuan Dokumen Siswa
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.verifikasi.index') }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ !$status ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600' }}">Semua</a>
                <a href="{{ route('admin.verifikasi.index', ['status' => 'diajukan']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $status == 'diajukan' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-600' }}">Perlu Ditinjau</a>
                <a href="{{ route('admin.verifikasi.index', ['status' => 'diproses']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $status == 'diproses' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">Diproses</a>
                <a href="{{ route('admin.verifikasi.index', ['status' => 'selesai']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $status == 'selesai' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600' }}">Selesai</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Tgl Masuk</th>
                                <th class="px-6 py-3 text-left">Nama Siswa / NIS</th>
                                <th class="px-6 py-3 text-left">Layanan Surat</th>
                                <th class="px-6 py-3 text-left">Perihal</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($pengajuans as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs">{{ $item->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $item->user->name }}
                                        <span class="block text-xs text-gray-400">NIS: {{ $item->user->nis_nip ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-800">{{ $item->jenisDokumen->nama_dokumen }}</td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $item->judul }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                            @if($item->status == 'diajukan') bg-amber-100 text-amber-800
                                            @elseif($item->status == 'disetujui' || $item->status == 'selesai') bg-emerald-100 text-emerald-800
                                            @elseif($item->status == 'ditolak') bg-rose-100 text-rose-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-lg">
                                            Periksa &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                        Tidak ada berkas permohonan yang sesuai kriteria.
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