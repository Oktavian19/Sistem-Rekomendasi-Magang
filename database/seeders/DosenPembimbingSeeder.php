<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenPembimbingSeeder extends Seeder
{
    public function run()
    {
        $dosen = [
            ['username' => '0028029101', 'nidn' => '0028029101', 'nama' => 'Abdul Muhsyi, S.Kom., M.MSI', 'email' => 'abdulmuhsyi@example.com', 'bidang_minat' => ['Machine Learning', 'Data Mining', 'Deep Learning'], ],
            ['username' => '0728099401', 'nidn' => '0728099401', 'nama' => 'Amalia Agung Septarina, S.S.T, M.Tr.T.', 'email' => 'amaliaagung@example.com', 'bidang_minat' => ['Machine Learning', 'Rekayasa Perangkat Lunak', 'Deep Learning'], ],
            ['username' => '0023018906', 'nidn' => '0023018906', 'nama' => 'Annisa Puspa Kirana, S.Kom., M.Kom.', 'email' => 'annisapuspa@example.com', 'bidang_minat' => ['Rekayasa Perangkat Lunak', 'Pemrograman Web']],
            ['username' => '0014128704', 'nidn' => '0014128704', 'nama' => 'Annisa Taufika Firdausi, S.T., M.T.', 'email' => 'annisataufika@example.com', 'bidang_minat' => ['Sistem Informasi', 'Manajemen Proyek TI']],
            ['username' => '0024088701', 'nidn' => '0024088701', 'nama' => 'Arie Rachmad Syulistyo, S.Kom., M.Kom', 'email' => 'arierachmad@example.com', 'bidang_minat' => ['Jaringan Komputer', 'Keamanan Siber']],
            ['username' => '0013037905', 'nidn' => '0013037905', 'nama' => 'Arief Prasetyo, S.Kom., M.Kom.', 'email' => 'ariefprasetyo@example.com', 'bidang_minat' => ['Machine Learning', 'Keamanan Siber']],
            ['username' => '0021059405', 'nidn' => '0021059405', 'nama' => 'Astrifidha Rahma Amalia, S.Pd,. M.Pd.', 'email' => 'astrifidharahma@example.com', 'bidang_minat' => ['Artificial Intelligence', 'Robotics', 'Deep Learning']],
            ['username' => '0002027214', 'nidn' => '0002027214', 'nama' => 'Prof. Dr. Eng. Cahya Rahmad, S.T., M.Kom.', 'email' => 'cahyarahmad@example.com', 'bidang_minat' => ['Statistika Komputasi', 'Analisis Data']],
            ['username' => '0017129402', 'nidn' => '0017129402', 'nama' => 'Candra Bella Vista, S.Kom., M.T.', 'email' => 'candrabella@example.com', 'bidang_minat' => ['Jaringan Komputer', 'Deep Learning']],
            ['username' => '0008129002', 'nidn' => '0008129002', 'nama' => 'Deasy Sandhya Elya Ikawati, S.Si., M.Si.', 'email' => 'deasysandhya@example.com', 'bidang_minat' => ['Machine Learning', 'Robotics']],
            ['username' => '0009118305', 'nidn' => '0009118305', 'nama' => 'Dhebys Suryani Hormansyah, S.Kom., M.T.', 'email' => 'dhebyssuryani@example.com', 'bidang_minat' => ['Artificial Intelligence', 'Robotics']],
            ['username' => '0006069202', 'nidn' => '0006069202', 'nama' => 'Dika Rizky Yunianto, S.Kom., M.Kom.', 'email' => 'dikarizky@example.com', 'bidang_minat' => ['Deep Learning', 'Cloud Infrastructure']],
            ['username' => '0010068807', 'nidn' => '0010068807', 'nama' => 'Dian Hanifudin Subhi, S.Kom., M.Kom', 'email' => 'dianhanifudin@example.com', 'bidang_minat' => ['Machine Learning', 'Rekayasa Perangkat Lunak']],
            ['username' => '0009108402', 'nidn' => '0009108402', 'nama' => 'Dimas Wahyu Wibowo, S.T., M.T.', 'email' => 'dwwnihbosss@example.com', 'bidang_minat' => ['Manajemen Proyek TI', 'Pemrograman Web', 'DevOps']],
            ['username' => '0716037502', 'nidn' => '0716037502', 'nama' => 'Dodit Suprianto, S.Kom., M.T.', 'email' => 'doditsuprianto@example.com', 'bidang_minat' => ['Rekayasa Perangkat Lunak', 'Machine Learning']],
        ];

        foreach ($dosen as $dsn) {
            $id = DB::table('users')->where('username', $dsn['username'])->value('id_user');

            DB::table('dosen_pembimbing')->insert([
                'id_dosen_pembimbing' => $id,
                'nidn' => $dsn['nidn'],
                'nama' => $dsn['nama'],
                'email' => $dsn['email'],
                'no_hp' => '08123456789',
                'bidang_minat' => implode(', ', $dsn['bidang_minat']),
            ]);
        }
    }
}
