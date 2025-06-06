<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->unsignedBigInteger('id_admin')->primary();
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->string('no_hp', 20);
            $table->string('foto_profil', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_admin')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
