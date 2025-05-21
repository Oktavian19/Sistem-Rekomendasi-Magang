<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('program_studi')->insert([
            ['kode_program_studi' => 'D4TI', 'nama_program_studi' => 'D-IV Teknik Informatika'],
            ['kode_program_studi' => 'D4SIB', 'nama_program_studi' => 'D-IV Sistem Informasi Bisnis'],
            ['kode_program_studi' => 'D2PPL', 'nama_program_studi' => 'D-II Pengembangan Piranti Lunak'],
            ['kode_program_studi' => 'S2RTI', 'nama_program_studi' => 'S-2 Rekayasa Teknologi Informasi'],
        ]);
    }
}
