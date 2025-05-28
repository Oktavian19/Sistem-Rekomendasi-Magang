<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPreferensiSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['kode' => 'jarak',             'nama' => 'Jarak'],
            ['kode' => 'durasi_magang',     'nama' => 'Durasi Magang'],
            ['kode' => 'jenis_pelaksanaan ','nama' => 'Jenis Pelaksanaan'],
            ['kode' => 'jenis_perusahaan',  'nama' => 'Jenis Perusahaan'],
            ['kode' => 'bidang_keahlian',   'nama' => 'Bidang Keahlian'],
            ['kode' => 'fasilitas',         'nama' => 'Fasilitas'],
        ];

        foreach ($kategori as $k) {
            DB::table('kategori_preferensi')->insert([
                    'kode'  => $k['kode'],
                    'nama' => $k['nama'],
                    'created_at' => now(),
            ]);
        }
    }
}
