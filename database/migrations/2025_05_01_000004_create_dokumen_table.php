<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->unsignedBigInteger('id_user');
            $table->enum('jenis_dokumen', ['Curriculum Vitae (CV)', 'Ijazah', 'Transkrip Nilai', 'Sertifikat', 'KTP', 'NPWP', 'SIM', 'Lainnya']);
            $table->string('path_file', 255);
            $table->dateTime('tanggal_upload');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen');
    }
};
