<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id('id_program_studi');
            $table->string('nama_program_studi', 100);
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_studi');
    }
};
