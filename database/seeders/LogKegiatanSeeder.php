<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LogKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Asumsikan id_magang 1 sampai 3 sudah ada di tabel magang
        $data = [
            [
                'id_magang' => 1,
                'tanggal' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'deskripsi_kegiatan' => 'Melakukan pendataan alat laboratorium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_magang' => 2,
                'tanggal' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'deskripsi_kegiatan' => 'Membantu pengolahan data hasil survei',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_magang' => 3,
                'tanggal' => Carbon::now()->subDay()->format('Y-m-d'),
                'deskripsi_kegiatan' => 'Mengikuti rapat mingguan divisi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('log_kegiatan')->insert($data);
    }
}
