<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id_feedback'); 

            $table->unsignedBigInteger('id_user'); 
            $table->unsignedBigInteger('id_magang')->nullable(); 
            $table->unsignedBigInteger('id_log')->nullable();
            $table->text('komentar');
            $table->date('tanggal_feedback');

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->onDelete('cascade');

            $table->foreign('id_magang')
                ->references('id_magang')->on('magang')
                ->onDelete('cascade');

            $table->foreign('id_log')
                ->references('id_log')->on('log_kegiatan')
                ->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
