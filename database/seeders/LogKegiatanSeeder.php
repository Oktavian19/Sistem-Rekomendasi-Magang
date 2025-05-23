<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('log_kegiatan')->insert([
            ['id_magang' => 1, 'tanggal' => '2023-08-10', 'deskripsi_kegiatan' => 'Review kode dengan tim', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 1, 'tanggal' => '2023-10-12', 'deskripsi_kegiatan' => 'Orientasi dan pengenalan lingkungan kerja', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 1, 'tanggal' => '2023-12-20', 'deskripsi_kegiatan' => 'Menulis laporan kegiatan magang', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 2, 'tanggal' => '2023-09-08', 'deskripsi_kegiatan' => 'Setup akun dan akses ke sistem', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 2, 'tanggal' => '2023-11-19', 'deskripsi_kegiatan' => 'Belajar alur kerja aplikasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 2, 'tanggal' => '2023-12-24', 'deskripsi_kegiatan' => 'Membantu pengujian aplikasi', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 3, 'tanggal' => '2024-10-06', 'deskripsi_kegiatan' => 'Mempelajari dokumentasi proyek', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 3, 'tanggal' => '2024-11-12', 'deskripsi_kegiatan' => 'Bertemu dengan mentor untuk diskusi tugas', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 3, 'tanggal' => '2024-12-24', 'deskripsi_kegiatan' => 'Membuat modul API sederhana', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 4, 'tanggal' => '2025-02-08', 'deskripsi_kegiatan' => 'Setup environment pengembangan', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 4, 'tanggal' => '2025-05-12', 'deskripsi_kegiatan' => 'Debugging dan perbaikan bug minor', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 4, 'tanggal' => '2025-07-29', 'deskripsi_kegiatan' => 'Menulis dokumentasi teknis', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 5, 'tanggal' => '2025-03-07', 'deskripsi_kegiatan' => 'Menganalisis kebutuhan pengguna', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 5, 'tanggal' => '2025-04-08', 'deskripsi_kegiatan' => 'Membuat wireframe dan prototipe UI', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 5, 'tanggal' => '2025-06-09', 'deskripsi_kegiatan' => 'Uji coba fitur baru', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 6, 'tanggal' => '2024-03-10', 'deskripsi_kegiatan' => 'Rapat evaluasi tengah magang', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 6, 'tanggal' => '2024-05-11', 'deskripsi_kegiatan' => 'Refactor kode lama', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 6, 'tanggal' => '2024-07-12', 'deskripsi_kegiatan' => 'Finalisasi laporan magang', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 7, 'tanggal' => '2025-02-13', 'deskripsi_kegiatan' => 'Bimbingan tugas akhir magang', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 7, 'tanggal' => '2025-05-14', 'deskripsi_kegiatan' => 'Membuat modul sistem login', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 7, 'tanggal' => '2025-07-15', 'deskripsi_kegiatan' => 'Mempresentasikan hasil kerja', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 8, 'tanggal' => '2025-01-16', 'deskripsi_kegiatan' => 'Pembuatan dokumentasi API', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 8, 'tanggal' => '2025-05-17', 'deskripsi_kegiatan' => 'Pemrograman fitur dashboard', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 8, 'tanggal' => '2025-07-18', 'deskripsi_kegiatan' => 'Uji coba dan revisi fitur', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 9, 'tanggal' => '2024-02-19', 'deskripsi_kegiatan' => 'Analisis performa aplikasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 9, 'tanggal' => '2024-04-20', 'deskripsi_kegiatan' => 'Pengoptimalan query database', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 9, 'tanggal' => '2024-07-21', 'deskripsi_kegiatan' => 'Sinkronisasi repository tim', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 10, 'tanggal' => '2024-09-22', 'deskripsi_kegiatan' => 'Melakukan benchmarking sistem', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 10, 'tanggal' => '2024-10-23', 'deskripsi_kegiatan' => 'Implementasi caching', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 10, 'tanggal' => '2024-12-24', 'deskripsi_kegiatan' => 'Penutupan program magang', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 11, 'tanggal' => '2025-02-25', 'deskripsi_kegiatan' => 'Penyusunan laporan akhir', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 11, 'tanggal' => '2025-05-26', 'deskripsi_kegiatan' => 'Diskusi akhir dengan pembimbing', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 11, 'tanggal' => '2025-06-27', 'deskripsi_kegiatan' => 'Evaluasi hasil magang', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 12, 'tanggal' => '2024-01-28', 'deskripsi_kegiatan' => 'Penyerahan dokumen akhir', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 12, 'tanggal' => '2024-03-29', 'deskripsi_kegiatan' => 'Diskusi kelulusan magang', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 12, 'tanggal' => '2024-06-30', 'deskripsi_kegiatan' => 'Pelepasan peserta magang', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 13, 'tanggal' => '2024-08-01', 'deskripsi_kegiatan' => 'Kickoff meeting dengan tim', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 13, 'tanggal' => '2024-10-02', 'deskripsi_kegiatan' => 'Implementasi UI berbasis React', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 13, 'tanggal' => '2024-12-03', 'deskripsi_kegiatan' => 'Code review harian', 'created_at' => now(), 'updated_at' => now()],
            
            ['id_magang' => 14, 'tanggal' => '2025-02-04', 'deskripsi_kegiatan' => 'Pembuatan form digital', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 14, 'tanggal' => '2025-03-05', 'deskripsi_kegiatan' => 'Integrasi dengan backend', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 14, 'tanggal' => '2025-06-06', 'deskripsi_kegiatan' => 'Uji kelayakan sistem', 'created_at' => now(), 'updated_at' => now()],
        
            ['id_magang' => 15, 'tanggal' => '2025-02-07', 'deskripsi_kegiatan' => 'Pengenalan teknologi baru', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 15, 'tanggal' => '2025-05-08', 'deskripsi_kegiatan' => 'Penerapan RESTful API', 'created_at' => now(), 'updated_at' => now()],
            ['id_magang' => 15, 'tanggal' => '2025-07-09', 'deskripsi_kegiatan' => 'Evaluasi mingguan dengan tim', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
