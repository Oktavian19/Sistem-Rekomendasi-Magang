<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DokumenLogKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id_log' => 1,
                'path_file' => 'uploads/logs/log1_' . Str::random(5) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_log' => 2,
                'path_file' => 'uploads/logs/log2_' . Str::random(5) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_log' => 3,
                'path_file' => 'uploads/logs/log3_' . Str::random(5) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('dokumen_log_kegiatan')->insert($data);
    }
}
