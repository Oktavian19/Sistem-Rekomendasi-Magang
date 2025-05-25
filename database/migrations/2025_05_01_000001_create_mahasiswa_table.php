<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mahasiswa')->primary();
            $table->string('nim', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 100)->nullable();
            $table->string('alamat', 500)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('preferensi_lokasi', 100)->nullable();
            $table->decimal('latitude', 9, 6)->nullable()->comment('GPS latitude (WGS84)');
            $table->decimal('longitude', 9, 6)->nullable()->comment('GPS longitude (WGS84)');
            $table->unsignedBigInteger('id_program_studi');
            $table->string('foto_profil', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_mahasiswa')
                ->references('id_user')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_program_studi')
                ->references('id_program_studi')
                ->on('program_studi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
};
