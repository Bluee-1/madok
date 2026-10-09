<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Master Data — Jenis Dokumen Akademik
            </h2>
            <a href="{{ route('admin.jenis-dokumen.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
                + Tambah Jenis Dokumen
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <!-- Notifikasi Alert -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabel Data -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama Layanan Dokumen</th>
                                <th class="px-6 py-3 text-left">Kategori</th>
                                <th class="px-6 py-3 text-left">Deskripsi / Ketentuan</th>
                                <th class="px-6 py-3 text-center">Penggunaan</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($jenisDokumen as $dokumen)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ $dokumen->nama_dokumen }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                            @if($dokumen->kategori == 'Surat Keterangan') bg-blue-100 text-blue-800 
                                            @elseif($dokumen->kategori == 'Legalisir') bg-purple-100 text-purple-800 
                                            @else bg-amber-100 text-amber-800 @endif">
                                            {{ $dokumen->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                                        {{ $dokumen->deskripsi ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">
                                            {{ $dokumen->pengajuans_count }} pengajuan
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('admin.jenis-dokumen.edit', $dokumen->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                        <form action="{{ route('admin.jenis-dokumen.destroy', $dokumen->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-900 font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        Belum ada data jenis dokumen akademik.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $jenisDokumen->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>