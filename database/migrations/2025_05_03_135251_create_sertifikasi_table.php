<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id('id_sertifikasi')->primary();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->string('nama_sertifikasi', 100);
            $table->string('penerbit', 100)->nullable();
            $table->date('tanggal_diterbitkan')->nullable();

            $table->foreign('id_mahasiswa')
                  ->references('id')
                  ->on('mahasiswa')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikasi');
    }
};
