<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kriteria_rekomendasi', function (Blueprint $table) {
            $table->id('id_kriteria_rekomendasi');
            $table->string('nama_kriteria', 100);
            $table->enum('jenis_kriteria', ['benefit', 'cost']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kriteria_rekomendasi');
    }
};
