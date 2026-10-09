<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Jenis Dokumen: {{ $jenisDokumen->nama_dokumen }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <form action="{{ route('admin.jenis-dokumen.update', $jenisDokumen->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Layanan Dokumen</label>
                        <input type="text" name="nama_dokumen" value="{{ old('nama_dokumen', $jenisDokumen->nama_dokumen) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('nama_dokumen') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori Dokumen</label>
                        <select name="kategori" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="Surat Keterangan" {{ old('kategori', $jenisDokumen->kategori) == 'Surat Keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                            <option value="Legalisir" {{ old('kategori', $jenisDokumen->kategori) == 'Legalisir' ? 'selected' : '' }}>Legalisir</option>
                            <option value="Pengaduan" {{ old('kategori', $jenisDokumen->kategori) == 'Pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                        </select>
                        @error('kategori') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi & Syarat Pengajuan</label>
                        <textarea name="deskripsi" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('deskripsi', $jenisDokumen->deskripsi) }}</textarea>
                        @error('deskripsi') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.jenis-dokumen.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>