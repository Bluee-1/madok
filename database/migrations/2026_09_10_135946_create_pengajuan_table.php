<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumen')->restrictOnDelete();
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->enum('status', ['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->text('catatan_admin')->nullable();
            $table->dateTime('tanggal_pengajuan')->useCurrent();
            $table->dateTime('tanggal_diproses')->nullable();
            $table->timestamps();

            $table->index(['status', 'tanggal_pengajuan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};