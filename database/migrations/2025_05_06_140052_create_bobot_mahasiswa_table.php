<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bobot_mahasiswa', function (Blueprint $table) {
            $table->id('id_bobot_mahasiswa')->primary();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_kriteria_rekomendasi');
            $table->float('nilai_bobot');
            $table->timestamps();

            $table->foreign('id_mahasiswa')
                ->references('id_mahasiswa')->on('mahasiswa')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_kriteria_rekomendasi')
                ->references('id_kriteria_rekomendasi')->on('kriteria_rekomendasi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bobot_mahasiswa');
    }
};
