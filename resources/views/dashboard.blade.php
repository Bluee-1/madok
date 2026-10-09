<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->role === 'admin' ? 'Panel Petugas Tata Usaha' : 'Panel Siswa' }} — MADOK
            </h2>
            @if(Auth::user()->role === 'siswa')
                <a href="{{ route('siswa.pengajuan.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
                    + Ajukan Dokumen Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informasi Akun -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        NIS / NIP: <span class="font-medium text-gray-700">{{ Auth::user()->nis_nip ?? '-' }}</span> | 
                        Peran: <span class="uppercase font-semibold text-indigo-600">{{ Auth::user()->role }}</span>
                    </p>
                </div>
            </div>

            <!-- TAMPILAN 1: DASHBOARD KHUSUS ADMIN -->
            @if(Auth::user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total Masuk</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPengajuan ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-amber-600">Perlu Verifikasi</p>
                        <p class="text-3xl font-bold text-amber-600 mt-2">{{ $menungguVerifikasi ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-blue-600">Disetujui</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $disetujui ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-emerald-600">Selesai</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $selesai ?? 0 }}</p>
                    </div>
                </div>

            <!-- TAMPILAN 2: DASHBOARD KHUSUS SISWA -->
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total Pengajuan Anda</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalDiajukan ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-amber-600">Sedang Diproses</p>
                        <p class="text-3xl font-bold text-amber-600 mt-2">{{ $totalDiproses ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-sm font-medium text-emerald-600">Dokumen Selesai</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalSelesai ?? 0 }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>