<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangKeahlianSeeder extends Seeder
{
    public function run(): void
    {
        $bidang = [
            ['nama_bidang' => 'Backend Development',    'deskripsi' => 'Pengembangan logika server dan manajemen database'],
            ['nama_bidang' => 'Frontend Development',   'deskripsi' => 'Pengembangan antarmuka pengguna dengan HTML/CSS/JS'],
            ['nama_bidang' => 'Full-Stack Development', 'deskripsi' => 'Pengembangan aplikasi end-to-end (frontend + backend)'],
            ['nama_bidang' => 'DevOps Engineering',     'deskripsi' => 'Otomatisasi infrastruktur dan pipeline deployment'],
            ['nama_bidang' => 'Mobile Development',     'deskripsi' => 'Pengembangan aplikasi Android/iOS'],
            ['nama_bidang' => 'Game Development',       'deskripsi' => 'Pengembangan game dan simulasi interaktif'],
            ['nama_bidang' => 'Data Science',           'deskripsi' => 'Analisis data dan pemodelan statistik'],
            ['nama_bidang' => 'Artificial Intelligence','deskripsi' => 'Pengembangan sistem kecerdasan buatan'],
            ['nama_bidang' => 'Machine Learning',       'deskripsi' => 'Pembuatan model pembelajaran mesin'],
            ['nama_bidang' => 'Cybersecurity',          'deskripsi' => 'Keamanan sistem dan proteksi data'],
            ['nama_bidang' => 'Cloud Computing',        'deskripsi' => 'Manajemen infrastruktur cloud (AWS/GCP/Azure)'],
            ['nama_bidang' => 'Quality Assurance',      'deskripsi' => 'Pengujian dan penjaminan kualitas software'],
            ['nama_bidang' => 'Database Administration','deskripsi' => 'Manajemen dan optimasi database'],
            ['nama_bidang' => 'Blockchain Development', 'deskripsi' => 'Pengembangan aplikasi terdesentralisasi'],
            ['nama_bidang' => 'Embedded Systems',       'deskripsi' => 'Pemrograman sistem tertanam dan IoT'],
            ['nama_bidang' => 'UI/UX Design',           'deskripsi' => 'Desain antarmuka dan pengalaman pengguna'],
            ['nama_bidang' => 'Systems Architecture',   'deskripsi' => 'Desain arsitektur sistem berskala besar'],
            ['nama_bidang' => 'API Development',        'deskripsi' => 'Pengembangan dan integrasi API'],
            ['nama_bidang' => 'IoT Engineering',        'deskripsi' => 'Pengembangan sistem Internet of Things'],
            ['nama_bidang' => 'Computer Vision',        'deskripsi' => 'Pengembangan sistem penglihatan komputer'],
            ['nama_bidang' => 'Digital Marketing',      'deskripsi' => 'Pemasaran produk melalui platform digital'],
            ['nama_bidang' => 'Technical Writing',      'deskripsi' => 'Pembuatan dokumentasi teknis dan manual'],
            ['nama_bidang' => 'Project Management',     'deskripsi' => 'Manajemen proyek dan koordinasi tim'],
            ['nama_bidang' => 'Product Management',     'deskripsi' => 'Pengelolaan siklus hidup produk'],
            ['nama_bidang' => 'Business Analysis',      'deskripsi' => 'Analisis kebutuhan bisnis dan solusi TI'],
            ['nama_bidang' => 'Content Creation',       'deskripsi' => 'Pembuatan konten kreatif dan edukatif'],
            ['nama_bidang' => 'Graphic Design',         'deskripsi' => 'Desain visual dan komunikasi grafis'],
            ['nama_bidang' => 'Social Media Management','deskripsi' => 'Pengelolaan dan strategi media sosial'],
            ['nama_bidang' => 'Data Analysis',          'deskripsi' => 'Analisis data bisnis non-teknis'],
            ['nama_bidang' => 'Human Resources IT',     'deskripsi' => 'Manajemen SDM di perusahaan teknologi']
        ];

        foreach ($bidang as $b) {
            DB::table('bidang_keahlian')->insert([
                    'nama_bidang'  => $b['nama_bidang'],
                    'deskripsi' => $b['deskripsi'],
                    'created_at' => now(),
            ]);
        }
    }
}
