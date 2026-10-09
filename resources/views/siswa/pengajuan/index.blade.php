<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Pengajuan Dokumen Saya
            </h2>
            <a href="{{ route('siswa.pengajuan.create') }}" 
                style="background-color: #4f46e5; color: #ffffff;"
                class="px-4 py-2 hover:opacity-90 text-sm font-semibold rounded-lg shadow">
                + Buat Pengajuan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Tanggal</th>
                                <th class="px-6 py-3 text-left">Jenis Layanan</th>
                                <th class="px-6 py-3 text-left">Perihal</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($pengajuans as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap text-xs">
                                        {{ $p->tanggal_pengajuan->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ $p->jenisDokumen->nama_dokumen }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $p->judul }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                            @if($p->status == 'diajukan') bg-amber-100 text-amber-800
                                            @elseif($p->status == 'disetujui' || $p->status == 'selesai') bg-emerald-100 text-emerald-800
                                            @elseif($p->status == 'ditolak') bg-rose-100 text-rose-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('siswa.pengajuan.show', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">
                                            Lihat Detail &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        Anda belum pernah membuat pengajuan dokumen.
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