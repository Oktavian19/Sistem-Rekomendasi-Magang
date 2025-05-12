<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id('id_sertifikat');
            $table->unsignedBigInteger('id_magang');
            $table->string('path_sertifikat', 100);
            $table->enum('status_sertifikat', ['belum', 'diproses', 'diterbitkan']);
            $table->timestamps();

            $table->foreign('id_magang')
                  ->references('id_magang')
                  ->on('magang')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
