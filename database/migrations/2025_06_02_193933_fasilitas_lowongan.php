<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_lowongan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lowongan');
            $table->unsignedBigInteger('id_fasilitas');
            $table->timestamps();

            $table->foreign('id_lowongan')
                ->references('id_lowongan')
                ->on('lowongan')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_fasilitas')
                ->references('id')
                ->on('opsi_preferensi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_lowongan');
    }
};
