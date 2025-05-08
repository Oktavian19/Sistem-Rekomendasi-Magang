<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('preferensi_lokasi', function (Blueprint $table) {
            $table->id('id_preferensi_lokasi');
            $table->string('nama_lokasi', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('preferensi_lokasi');
    }
};
