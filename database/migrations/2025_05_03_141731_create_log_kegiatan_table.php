<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_kegiatan', function (Blueprint $table) {
            $table->id('id_log')->primary();
            $table->foreignId('id_magang')->constrained('magang')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('deskripsi_kegiatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_kegiatan');
    }
};
