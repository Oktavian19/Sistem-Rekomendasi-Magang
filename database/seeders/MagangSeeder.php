<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagangSeeder extends Seeder
{
    public function run(): void
    {
        $magang = [
            ['id_lamaran' => '31','id_dosen_pembimbing' => '34', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '24','id_dosen_pembimbing' => '34', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '22','id_dosen_pembimbing' => '34', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '20','id_dosen_pembimbing' => '35', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '19','id_dosen_pembimbing' => '35', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '30','id_dosen_pembimbing' => '36', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '25','id_dosen_pembimbing' => '37', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '33','id_dosen_pembimbing' => '37', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '37','id_dosen_pembimbing' => '38', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '7','id_dosen_pembimbing' => '39', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '35','id_dosen_pembimbing' => '39', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '10','id_dosen_pembimbing' => '40', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '14','id_dosen_pembimbing' => '43', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '15','id_dosen_pembimbing' => '43', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '40','id_dosen_pembimbing' => '45', 'id_periode' => '4', 'status_magang' => 'aktif'],
        ];

        foreach ($magang as $m) {
            DB::table('magang')->insert([
                'id_lamaran' => $m['id_lamaran'],
                'id_dosen_pembimbing' => $m['id_dosen_pembimbing'],
                'id_periode' => $m['id_periode'],
                'status_magang' => $m['status_magang'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
