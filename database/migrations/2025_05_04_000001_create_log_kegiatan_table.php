<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_kegiatan', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_magang');
            $table->date('tanggal');
            $table->string('minggu');
            $table->text('deskripsi_kegiatan');
            $table->timestamps(); 

             $table->foreign('id_magang')
                ->references('id_magang')->on('magang')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('log_kegiatan');
    }
};
