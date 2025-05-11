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
            ['id_program_studi' => 1, 'nama_program_studi' => 'D-IV Teknik Informatika'],
            ['id_program_studi' => 2, 'nama_program_studi' => 'D-IV Sistem Informasi Bisnis'],
            ['id_program_studi' => 3, 'nama_program_studi' => 'D-II Pengembangan Piranti Lunak'],
            ['id_program_studi' => 4, 'nama_program_studi' => 'S-2 Rekayasa Teknologi Informasi'],
        ]);
    }
}
