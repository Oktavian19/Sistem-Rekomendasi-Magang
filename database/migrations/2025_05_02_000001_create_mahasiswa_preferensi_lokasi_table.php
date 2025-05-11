<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa_preferensi_lokasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_preferensi_lokasi');
            $table->timestamps(); 

            $table->primary(['id_mahasiswa', 'id_preferensi_lokasi']);

            $table->foreign('id_mahasiswa')
                  ->references('id_mahasiswa')
                  ->on('mahasiswa')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_preferensi_lokasi')
                  ->references('id_preferensi_lokasi')
                  ->on('preferensi_lokasi')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_preferensi_lokasi');
    }
};
