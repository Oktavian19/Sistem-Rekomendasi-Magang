<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('nim', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->string('no_hp', 20);
            $table->unsignedInteger('id_program_studi');

            $table->foreign('id_mahasiswa')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_program_studi')
                  ->references('id')
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