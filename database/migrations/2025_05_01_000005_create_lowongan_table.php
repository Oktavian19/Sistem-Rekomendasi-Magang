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
            $table->enum('jenis_magang', ['WFO', 'WFH', 'Hybrid']);
            $table->text('deskripsi');
            $table->unsignedBigInteger('id_bidang_keahlian');
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
                  
            $table->foreign('id_bidang_keahlian')
                ->references('id_bidang_keahlian')
                ->on('bidang_keahlian')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
