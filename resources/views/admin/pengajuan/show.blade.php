<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Verifikasi Berkas Dokumen #{{ $pengajuan->id }}
            </h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">
                &larr; Kembali ke Antrean
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Data Siswa & Berkas -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                        <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2">Identitas Permohonan Siswa</h3>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-400">Nama Siswa:</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">NIS Siswa:</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->user->nis_nip ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Jenis Layanan:</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->jenisDokumen->nama_dokumen }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Waktu Masuk:</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-400">Perihal:</p>
                                <p class="font-semibold text-gray-800">{{ $pengajuan->judul }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-400">Keterangan Siswa:</p>
                                <div class="bg-gray-50 p-3 rounded-lg text-gray-700 mt-1 whitespace-pre-line text-xs">
                                    {{ $pengajuan->deskripsi }}
                                </div>
                            </div>
                        </div>

                        <!-- Berkas Lampiran -->
                        <div class="pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-800 mb-2">Berkas Persyaratan Fisik:</h4>
                            <div class="flex flex-wrap gap-2">
                                @forelse($pengajuan->berkas as $file)
                                    <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank"
                                        class="inline-flex items-center space-x-2 px-3 py-2 bg-indigo-50 border border-indigo-100 rounded-lg text-sm text-indigo-700 font-medium hover:bg-indigo-100">
                                        <span>📄 Buka Berkas ({{ $file->nama_file }})</span>
                                    </a>
                                @empty
                                    <p class="text-xs text-rose-500">Tidak ada berkas terlampir.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Log Riwayat Status -->
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Log Riwayat Verifikasi</h4>
                        <div class="space-y-3">
                            @foreach($pengajuan->riwayatStatus as $log)
                                <div class="flex items-start space-x-3 text-xs">
                                    <span class="px-2 py-0.5 font-bold uppercase rounded bg-gray-100 text-gray-700">{{ $log->status_baru }}</span>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ $log->admin->name ?? 'Sistem / Siswa' }} 
                                            <span class="text-gray-400 font-normal">({{ $log->created_at->format('d/m/Y H:i') }})</span>
                                        </p>
                                        <p class="text-gray-500 mt-0.5">{{ $log->keterangan }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Keputusan Petugas TU -->
                <div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Tindakan Petugas TU</h3>

                        <form action="{{ route('admin.verifikasi.update', $pengajuan->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Status Pengajuan</label>
                                <select name="status" class="w-full rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan (Belum Diproses)</option>
                                    <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>Diproses (Sedang Disiapkan TU)</option>
                                    <option value="disetujui" {{ $pengajuan->status == 'disetujui' ? 'selected' : '' }}>Disetujui (Dokumen Siap Dicetak)</option>
                                    <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak (Berkas Tidak Lengkap)</option>
                                    <option value="selesai" {{ $pengajuan->status == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Diambil Siswa)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Catatan Tanggapan TU</label>
                                <textarea name="catatan_admin" rows="4" placeholder="Tuliskan catatan verifikasi..."
                                    class="w-full rounded-md border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">{{ old('catatan_admin', $pengajuan->catatan_admin) }}</textarea>
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow">
                                Simpan Keputusan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>