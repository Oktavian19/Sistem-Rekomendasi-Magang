<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('magang', function (Blueprint $table) {
            $table->bigIncrements('id_magang');
            
            $table->unsignedBigInteger('id_lamaran');
            $table->unsignedBigInteger('id_dosen_pembimbing');
            $table->unsignedBigInteger('id_periode');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_magang', ['aktif', 'selesai', 'batal']);

            $table->timestamps();

            $table->foreign('id_lamaran')
                ->references('id_lamaran')->on('lamaran')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('id_dosen_pembimbing')
                ->references('id_dosen_pembimbing')->on('dosen_pembimbing')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('id_periode')
                ->references('id_periode')->on('periode')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('magang');
    }
};
