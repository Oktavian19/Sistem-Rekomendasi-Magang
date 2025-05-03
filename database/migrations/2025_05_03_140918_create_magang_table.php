<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magang', function (Blueprint $table) {
            $table->id('id_magang');
            $table->foreignId('id_mahasiswa')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('id_lowongan')->constrained('lowongan')->onDelete('cascade');
            $table->foreignId('id_dosen_pembimbing')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('id_periode')->constrained('periode')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_magang', ['aktif', 'selesai', 'batal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
