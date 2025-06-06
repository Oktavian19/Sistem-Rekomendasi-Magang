<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id('id_lamaran');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_lowongan');
            $table->date('tanggal_lamaran');
            $table->enum('status_lamaran', ['diprosesAdmin', 'diprosesPerusahaan', 'diterima', 'ditolak']);
            $table->boolean('dari_rekomendasi')->default(false);
            $table->timestamps();

            $table->foreign('id_mahasiswa')
                ->references('id_mahasiswa')->on('mahasiswa')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_lowongan')
                ->references('id_lowongan')->on('lowongan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lamaran');
    }
};
