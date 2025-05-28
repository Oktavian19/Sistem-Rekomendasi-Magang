<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opsi_preferensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategori_preferensi')->onDelete('cascade');
            $table->string('kode', 50);
            $table->string('label', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opsi_preferensi');
    }
};
