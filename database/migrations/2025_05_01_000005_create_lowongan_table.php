<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id('id_lowongan');
            $table->unsignedBigInteger('id_perusahaan');
            $table->string('nama_posisi', 100);
            $table->text('deskripsi');
            $table->string('kategori_keahlian', 100);
            $table->integer('kuota');
            $table->text('persyaratan');
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->string('durasi_magang', 50);
            $table->timestamps(); 

            $table->foreign('id_perusahaan')
                  ->references('id_perusahaan')
                  ->on('perusahaan_mitra')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
