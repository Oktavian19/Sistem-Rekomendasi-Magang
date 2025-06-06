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
            $table->unsignedBigInteger('id_jenis_perusahaan');
            $table->text('alamat');
            $table->string('email', 100);
            $table->string('telepon', 20);
            $table->string('path_logo', 100)->default('storage/logo_perusahaan/logo-default.jpg');
            $table->timestamps();

            $table->foreign('id_jenis_perusahaan')
                ->references('id')
                ->on('opsi_preferensi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaan_mitra');
    }
};
