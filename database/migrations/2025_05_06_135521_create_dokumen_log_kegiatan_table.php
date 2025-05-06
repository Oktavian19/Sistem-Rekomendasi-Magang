<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_log_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id_dokumen_log_kegiatan');
            $table->unsignedBigInteger('id_log');
            $table->string('path_file', 100);
            $table->timestamps();

            $table->foreign('id_log')
                ->references('id_log')->on('log_kegiatan') 
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_log_kegiatan');
    }
};
