<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LamaranSeeder extends Seeder
{
    public function run(): void
    {
        $lamaran = [
            ['id_mahasiswa' => '4', 'id_lowongan' => '7', 'tanggal_lamaran' => '2025-06-02', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '4', 'id_lowongan' => '15', 'tanggal_lamaran' => '2025-06-02', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '4', 'id_lowongan' => '1', 'tanggal_lamaran' => '2025-06-05', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '5', 'id_lowongan' => '11', 'tanggal_lamaran' => '2025-05-23', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '5', 'id_lowongan' => '15', 'tanggal_lamaran' => '2025-06-10', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '5', 'id_lowongan' => '1', 'tanggal_lamaran' => '2025-06-15', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '5', 'id_lowongan' => '5', 'tanggal_lamaran' => '2025-06-16', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '6', 'id_lowongan' => '12', 'tanggal_lamaran' => '2025-06-26', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '6', 'id_lowongan' => '2', 'tanggal_lamaran' => '2025-07-01', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '7', 'id_lowongan' => '12', 'tanggal_lamaran' => '2025-06-14', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '8', 'id_lowongan' => '8', 'tanggal_lamaran' => '2025-07-03', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '8', 'id_lowongan' => '3', 'tanggal_lamaran' => '2025-07-04', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '9', 'id_lowongan' => '3', 'tanggal_lamaran' => '2025-07-22', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '10', 'id_lowongan' => '15', 'tanggal_lamaran' => '2025-06-24', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '11', 'id_lowongan' => '3', 'tanggal_lamaran' => '2025-07-18', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '11', 'id_lowongan' => '14', 'tanggal_lamaran' => '2025-07-20', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '11', 'id_lowongan' => '6', 'tanggal_lamaran' => '2025-07-19', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '12', 'id_lowongan' => '9', 'tanggal_lamaran' => '2025-02-28', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '13', 'id_lowongan' => '4', 'tanggal_lamaran' => '2025-07-17', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '14', 'id_lowongan' => '18', 'tanggal_lamaran' => '2025-07-11', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '14', 'id_lowongan' => '3', 'tanggal_lamaran' => '2025-07-14', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '15', 'id_lowongan' => '2', 'tanggal_lamaran' => '2025-06-06', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '16', 'id_lowongan' => '11', 'tanggal_lamaran' => '2025-06-15', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '17', 'id_lowongan' => '7', 'tanggal_lamaran' => '2025-06-28', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '18', 'id_lowongan' => '14', 'tanggal_lamaran' => '2025-07-08', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '18', 'id_lowongan' => '9', 'tanggal_lamaran' => '2025-07-15', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '18', 'id_lowongan' => '13', 'tanggal_lamaran' => '2025-07-20', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '19', 'id_lowongan' => '5', 'tanggal_lamaran' => '2025-07-12', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '20', 'id_lowongan' => '10', 'tanggal_lamaran' => '2025-06-29', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '21', 'id_lowongan' => '1', 'tanggal_lamaran' => '2025-06-25', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '22', 'id_lowongan' => '15', 'tanggal_lamaran' => '2025-06-28', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '22', 'id_lowongan' => '16', 'tanggal_lamaran' => '2025-07-22', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '23', 'id_lowongan' => '13', 'tanggal_lamaran' => '2025-07-20', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '24', 'id_lowongan' => '6', 'tanggal_lamaran' => '2025-06-30', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '25', 'id_lowongan' => '9', 'tanggal_lamaran' => '2025-07-17', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '26', 'id_lowongan' => '4', 'tanggal_lamaran' => '2025-06-14', 'status_lamaran' => 'diterima'],
            ['id_mahasiswa' => '27', 'id_lowongan' => '17', 'tanggal_lamaran' => '2025-07-01', 'status_lamaran' => 'menunggu'],
            ['id_mahasiswa' => '28', 'id_lowongan' => '8', 'tanggal_lamaran' => '2025-06-10', 'status_lamaran' => 'ditolak'],
            ['id_mahasiswa' => '28', 'id_lowongan' => '5', 'tanggal_lamaran' => '2025-06-15', 'status_lamaran' => 'diterima'],
        ];

        foreach ($lamaran as $l) {
            DB::table('lamaran')->insert([
                'id_mahasiswa' => $l['id_mahasiswa'],
                'id_lowongan' => $l['id_lowongan'],
                'tanggal_lamaran' => $l['tanggal_lamaran'],
                'status_lamaran' => $l['status_lamaran'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
