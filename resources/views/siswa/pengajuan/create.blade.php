<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Pengajuan Dokumen Akademik
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <form action="{{ route('siswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Layanan / Dokumen</label>
                        <select name="jenis_dokumen_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            @foreach($jenisDokumens as $item)
                                <option value="{{ $item->id }}" {{ old('jenis_dokumen_id') == $item->id ? 'selected' : '' }}>
                                    [{{ $item->kategori }}] {{ $item->nama_dokumen }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_dokumen_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Perihal / Keperluan Singkat</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required
                            placeholder="Contoh: Surat Keterangan Aktif untuk Tunjangan Gaji"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('judul') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan / Deskripsi Rincian</label>
                        <textarea name="deskripsi" rows="3" required
                            placeholder="Tuliskan keterangan detail pengajuan atau kebutuhan surat..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload Berkas Pendukung (PDF / JPG / PNG, Maks: 3MB)</label>
                        <input type="file" name="berkas" required
                            class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-gray-400 mt-1">Lampirkan bukti foto dokumen terkait atau berkas persyaratan sesuai ketentuan.</p>
                        @error('berkas') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg">
                            Batal
                        </a>
                        <button type="submit" 
                            style="background-color: #4f46e5; color: #ffffff;"
                            class="px-5 py-2 hover:opacity-90 text-sm font-semibold rounded-lg shadow">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>