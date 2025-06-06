<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dosen_pembimbing', function (Blueprint $table) {
         $table->unsignedBigInteger('id_dosen_pembimbing')->primary();
            $table->string('nidn', 20)->unique();
            $table->string('nama', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('bidang_minat', 100)->nullable();
              $table->string('foto_profil', 255)->nullable();
            $table->timestamps(); 

            $table->foreign('id_dosen_pembimbing')
                  ->references('id_user')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_pembimbing');
    }
};
