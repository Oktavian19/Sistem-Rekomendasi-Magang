<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('periode_magang')->insert([
            ['nama_periode' => 'Magang Semester Ganjil 2021/2022', 'tanggal_mulai' => '2021-08-10','tanggal_selesai' => '2021-12-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Genap 2021/2022', 'tanggal_mulai' => '2022-01-10','tanggal_selesai' => '2022-07-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Ganjil 2022/2023', 'tanggal_mulai' => '2022-08-10','tanggal_selesai' => '2022-12-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Genap 2022/2023', 'tanggal_mulai' => '2023-01-10','tanggal_selesai' => '2023-07-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Ganjil 2023/2024', 'tanggal_mulai' => '2023-08-10','tanggal_selesai' => '2023-12-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Genap 2023/2024', 'tanggal_mulai' => '2024-01-10','tanggal_selesai' => '2024-07-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Ganjil 2024/2025', 'tanggal_mulai' => '2024-08-10','tanggal_selesai' => '2024-12-25','created_at' => now(), 'status' => 'non-aktif'],
            ['nama_periode' => 'Magang Semester Genap 2024/2025', 'tanggal_mulai' => '2025-01-10','tanggal_selesai' => '2025-07-25','created_at' => now(), 'status' => 'aktif'],
        ]);
    }
}
