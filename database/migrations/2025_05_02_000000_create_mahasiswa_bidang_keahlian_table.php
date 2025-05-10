<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa_bidang_keahlian', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_bidang_keahlian');
            
            $table->primary(['id_mahasiswa', 'id_bidang_keahlian']);

            $table->foreign('id_mahasiswa')
                ->references('id')
                ->on('mahasiswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_bidang_keahlian')
                ->references('id')
                ->on('bidang_keahlian')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_bidang_keahlian');
    }
};