<?php

use App\Http\Controllers\Admin\JenisDokumenController;
use App\Http\Controllers\ProfileController;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\PengajuanController as SiswaPengajuanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\VerifikasiPengajuanController;

// Halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Redirector Dashboard Utama (Mengarahkan sesuai role pengguna)
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth'])->name('dashboard');

// ==========================================
// GRUP 1: KHUSUS ROLE ADMIN
// ==========================================
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
    Route::get('/dashboard', function () {
        $totalPengajuan = \App\Models\Pengajuan::count();
        $menungguVerifikasi = \App\Models\Pengajuan::where('status', 'diajukan')->count();
        $disetujui = \App\Models\Pengajuan::where('status', 'disetujui')->count();
        $selesai = \App\Models\Pengajuan::where('status', 'selesai')->count();
        $pengajuanTerbaru = \App\Models\Pengajuan::with(['user', 'jenisDokumen'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPengajuan',
            'menungguVerifikasi',
            'disetujui',
            'selesai',
            'pengajuanTerbaru'
        ));
    })->name('dashboard');
    
        // Master Data Dokumen (Fr-2)
        Route::resource('jenis-dokumen', JenisDokumenController::class)->parameters([
            'jenis-dokumen' => 'jenisDokumen',
        ]);

        // Verifikasi Pengajuan Siswa (Fr-4)
        Route::get('/verifikasi', [VerifikasiPengajuanController::class, 'index'])->name('verifikasi.index');
        Route::get('/verifikasi/{pengajuan}', [VerifikasiPengajuanController::class, 'show'])->name('verifikasi.show');
        Route::put('/verifikasi/{pengajuan}', [VerifikasiPengajuanController::class, 'update'])->name('verifikasi.update');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

    });

// ==========================================
// GRUP 2: KHUSUS ROLE SISWA
// ==========================================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $pengajuanSaya = \App\Models\Pengajuan::where('user_id', $user->id)
            ->with('jenisDokumen')
            ->latest()
            ->take(5)
            ->get();

        $totalDiajukan = \App\Models\Pengajuan::where('user_id', $user->id)->count();
        $totalDiproses = \App\Models\Pengajuan::where('user_id', $user->id)->whereIn('status', ['diajukan', 'diproses'])->count();
        $totalSelesai = \App\Models\Pengajuan::where('user_id', $user->id)->where('status', 'selesai')->count();

        return view('dashboard', compact('pengajuanSaya', 'totalDiajukan', 'totalDiproses', 'totalSelesai'));
    })->name('dashboard');

    // Rute Fitur Fr-3 Siswa
    Route::get('/pengajuan', [SiswaPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/buat', [SiswaPengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [SiswaPengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{pengajuan}', [SiswaPengajuanController::class, 'show'])->name('pengajuan.show');
});

// ==========================================
// GRUP 3: RUTE PROFIL (Mengatasi Error profile.edit)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';