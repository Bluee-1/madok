<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pengajuan #{{ $pengajuan->id }}
            </h2>
            <a href="{{ route('siswa.pengajuan.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">
                &larr; Kembali ke Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Banner Status Terkini -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Status Terkini</span>
                    <h3 class="text-2xl font-bold uppercase mt-1
                        @if($pengajuan->status == 'diajukan') text-amber-600
                        @elseif($pengajuan->status == 'disetujui' || $pengajuan->status == 'selesai') text-emerald-600
                        @elseif($pengajuan->status == 'ditolak') text-rose-600
                        @else text-blue-600 @endif">
                        {{ $pengajuan->status }}
                    </h3>
                </div>
                @if($pengajuan->catatan_admin)
                    <div class="max-w-md bg-gray-50 p-3 rounded-lg border border-gray-200 text-xs text-gray-700">
                        <strong class="text-gray-900 block mb-1">Catatan Petugas TU:</strong>
                        {{ $pengajuan->catatan_admin }}
                    </div>
                @endif
            </div>

            <!-- Detail Permohonan Siswa -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2">Informasi Permohonan</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Layanan Dokumen:</p>
                        <p class="font-semibold text-gray-800">{{ $pengajuan->jenisDokumen->nama_dokumen }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Diajukan:</p>
                        <p class="font-semibold text-gray-800">{{ $pengajuan->tanggal_pengajuan->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Perihal / Kebutuhan:</p>
                        <p class="font-semibold text-gray-800">{{ $pengajuan->judul }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Deskripsi / Penjelasan:</p>
                        <p class="text-gray-700 mt-1 whitespace-pre-line text-xs">{{ $pengajuan->deskripsi }}</p>
                    </div>
                </div>

                <!-- Berkas Unggahan -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-sm font-medium text-gray-700 mb-2">Berkas Persyaratan yang Diunggah:</p>
                    @forelse($pengajuan->berkas as $file)
                        <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank"
                            class="inline-flex items-center space-x-2 px-3 py-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg text-sm text-indigo-600 font-medium">
                            <span>📎 {{ $file->nama_file }}</span>
                            <span class="text-xs text-gray-400">(Buka Berkas)</span>
                        </a>
                    @empty
                        <p class="text-xs text-rose-500">Tidak ada berkas yang diunggah.</p>
                    @endforelse
                </div>
            </div>

            <!-- Log Audit Trail Kronologi Status -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Kronologi Status Pengajuan</h4>
                <div class="space-y-4">
                    @foreach($pengajuan->riwayatStatus as $log)
                        <div class="flex items-start space-x-3 text-sm">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 mt-1.5"></div>
                            <div>
                                <span class="font-semibold text-gray-800 uppercase">{{ $log->status_baru }}</span>
                                <span class="text-xs text-gray-400 ml-2">{{ $log->created_at->format('d M Y H:i') }}</span>
                                <p class="text-gray-600 text-xs mt-0.5">{{ $log->keterangan ?? 'Perubahan status dokumen.' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>