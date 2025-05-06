<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perusahaan_mitra', function (Blueprint $table) {
            $table->id('id_perusahaan'); 
            $table->string('nama_perusahaan', 100);
            $table->string('bidang_industri', 100);
            $table->text('alamat');
            $table->string('email', 100);
            $table->string('telepon', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaan_mitra');
    }
};
