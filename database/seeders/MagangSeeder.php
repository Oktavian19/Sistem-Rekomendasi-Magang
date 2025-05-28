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
            ['id_lamaran' => '7','id_dosen_pembimbing' => '255', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '9','id_dosen_pembimbing' => '255', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '13','id_dosen_pembimbing' => '256', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '14','id_dosen_pembimbing' => '257', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '18','id_dosen_pembimbing' => '257', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '19','id_dosen_pembimbing' => '258', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '21','id_dosen_pembimbing' => '259', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '22','id_dosen_pembimbing' => '259', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '23','id_dosen_pembimbing' => '260', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '24','id_dosen_pembimbing' => '261', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '29','id_dosen_pembimbing' => '261', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '30','id_dosen_pembimbing' => '262', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '32','id_dosen_pembimbing' => '263', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '34','id_dosen_pembimbing' => '263', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '36','id_dosen_pembimbing' => '264', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '39', 'id_dosen_pembimbing' => '265', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '40', 'id_dosen_pembimbing' => '265', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '44', 'id_dosen_pembimbing' => '266', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '46', 'id_dosen_pembimbing' => '266', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '50', 'id_dosen_pembimbing' => '266', 'id_periode' => '3', 'status_magang' => 'selesai'],
            ['id_lamaran' => '52', 'id_dosen_pembimbing' => '267', 'id_periode' => '4', 'status_magang' => 'selesai'],
            ['id_lamaran' => '55', 'id_dosen_pembimbing' => '267', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '59', 'id_dosen_pembimbing' => '258', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '62', 'id_dosen_pembimbing' => '262', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '63', 'id_dosen_pembimbing' => '260', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '66', 'id_dosen_pembimbing' => '268', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '69', 'id_dosen_pembimbing' => '268', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '70', 'id_dosen_pembimbing' => '269', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '71', 'id_dosen_pembimbing' => '264', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '72', 'id_dosen_pembimbing' => '255', 'id_periode' => '1', 'status_magang' => 'aktif'],
            ['id_lamaran' => '73', 'id_dosen_pembimbing' => '256', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '74', 'id_dosen_pembimbing' => '257', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '75', 'id_dosen_pembimbing' => '258', 'id_periode' => '4', 'status_magang' => 'selesai'],
            ['id_lamaran' => '76', 'id_dosen_pembimbing' => '259', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '77', 'id_dosen_pembimbing' => '260', 'id_periode' => '3', 'status_magang' => 'selesai'],
            ['id_lamaran' => '78', 'id_dosen_pembimbing' => '261', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '79', 'id_dosen_pembimbing' => '262', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '80', 'id_dosen_pembimbing' => '263', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '81', 'id_dosen_pembimbing' => '264', 'id_periode' => '3', 'status_magang' => 'selesai'],
            ['id_lamaran' => '82', 'id_dosen_pembimbing' => '265', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '83', 'id_dosen_pembimbing' => '266', 'id_periode' => '1', 'status_magang' => 'selesai'],
            ['id_lamaran' => '84', 'id_dosen_pembimbing' => '267', 'id_periode' => '2', 'status_magang' => 'aktif'],
            ['id_lamaran' => '85', 'id_dosen_pembimbing' => '268', 'id_periode' => '3', 'status_magang' => 'selesai'],
            ['id_lamaran' => '86', 'id_dosen_pembimbing' => '269', 'id_periode' => '4', 'status_magang' => 'aktif'],
            ['id_lamaran' => '87', 'id_dosen_pembimbing' => '255', 'id_periode' => '2', 'status_magang' => 'selesai'],
            ['id_lamaran' => '88', 'id_dosen_pembimbing' => '256', 'id_periode' => '3', 'status_magang' => 'aktif'],
            ['id_lamaran' => '89', 'id_dosen_pembimbing' => '257', 'id_periode' => '4', 'status_magang' => 'selesai'],
            ['id_lamaran' => '90', 'id_dosen_pembimbing' => '258', 'id_periode' => '1', 'status_magang' => 'aktif'],
            ['id_lamaran' => '91', 'id_dosen_pembimbing' => '259', 'id_periode' => '2', 'status_magang' => 'selesai'],
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