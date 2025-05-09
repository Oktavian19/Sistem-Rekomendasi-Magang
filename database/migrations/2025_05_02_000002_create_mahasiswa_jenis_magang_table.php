<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa_jenis_magang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_jenis_magang');
            $table->timestamps(); 

            $table->primary(['id_mahasiswa', 'id_jenis_magang']);

            $table->foreign('id_mahasiswa')
            ->references('id_mahasiswa')
            ->on('mahasiswa')
            ->onDelete('cascade');

            $table->foreign('id_jenis_magang')
            ->references('id_jenis_magang')
            ->on('jenis_magang')
            ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_jenis_magang');
    }
};
