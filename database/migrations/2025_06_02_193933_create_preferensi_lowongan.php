<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preferensi_lowongan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lowongan');
            $table->unsignedBigInteger('id_opsi');
            $table->timestamps();

            $table->primary(['id_lowongan', 'id_opsi']);

            $table->foreign('id_lowongan')
                ->references('id_lowongan')
                ->on('lowongan')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_opsi')
                ->references('id')
                ->on('opsi_preferensi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preferensi_lowongan');
    }
};
