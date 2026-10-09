<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MADOK — Manajemen Dokumen Akademik</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <div class="min-h-screen flex flex-col justify-between">
        
        <!-- Header Navigasi -->
        <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-black tracking-tight text-indigo-600">MADOK</span>
                    <span class="text-xs text-gray-400 border-l border-gray-200 pl-3">Sistem Dokumen Akademik</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                                Buka Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">
                                Masuk (Log in)
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                                    Registrasi Siswa
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Bagian Hero -->
        <main class="flex-1 flex items-center py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold tracking-wide uppercase">
                    Layanan Mandiri Siswa
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    Pengurusan Dokumen Akademik Sekolah Kini Lebih Cepat & Transparan
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Ajukan surat keterangan aktif, legalisir rapor, hingga pengaduan dokumen hilang secara online tanpa antre manual di loket Tata Usaha.
                </p>

                <div class="pt-4 flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow">
                            Ke Panel Dokumen Anda
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow">
                            Mulai Pengajuan
                        </a>
                    @endauth
                </div>

                <!-- 3 Alur Kerja Singkat -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-16 text-left">
                    <div class="p-5 bg-white border border-gray-100 rounded-xl shadow-sm">
                        <span class="text-indigo-600 font-bold text-lg">01.</span>
                        <h4 class="font-bold text-gray-800 mt-2">Isi Formulir</h4>
                        <p class="text-sm text-gray-500 mt-1">Pilih jenis dokumen dan unggah berkas persyaratan langsung dari HP atau komputer.</p>
                    </div>
                    <div class="p-5 bg-white border border-gray-100 rounded-xl shadow-sm">
                        <span class="text-indigo-600 font-bold text-lg">02.</span>
                        <h4 class="font-bold text-gray-800 mt-2">Verifikasi TU</h4>
                        <p class="text-sm text-gray-500 mt-1">Petugas memeriksa berkas permohonan secara berkala secara realtime.</p>
                    </div>
                    <div class="p-5 bg-white border border-gray-100 rounded-xl shadow-sm">
                        <span class="text-indigo-600 font-bold text-lg">03.</span>
                        <h4 class="font-bold text-gray-800 mt-2">Ambil Dokumen</h4>
                        <p class="text-sm text-gray-500 mt-1">Pantau status "Selesai" dari dashboard Anda dan ambil dokumen fisik di loket.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-100 py-6 bg-white">
            <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} MADOK — Tugas Akhir Rekayasa Perangkat Lunak.
            </div>
        </footer>

    </div>
</body>
</html>