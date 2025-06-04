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
            $table->unsignedBigInteger('id_jenis_pelaksanaan');
            $table->unsignedBigInteger('id_durasi_magang');
            $table->text('deskripsi');
            $table->integer('kuota');
            $table->text('persyaratan');
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->timestamps();

            $table->foreign('id_perusahaan')
                ->references('id_perusahaan')
                ->on('perusahaan_mitra')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_jenis_pelaksanaan')
                ->references('id')
                ->on('opsi_preferensi')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_durasi_magang')
                ->references('id')
                ->on('opsi_preferensi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
