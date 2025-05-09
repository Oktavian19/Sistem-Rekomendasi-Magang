<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dosen_pembimbing', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->string('nidn', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->string('no_hp', 20);
            $table->string('bidang_minat', 100)->nullable();
            $table->timestamps(); 

            $table->foreign('id_dosen')
                  ->references('id')
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
