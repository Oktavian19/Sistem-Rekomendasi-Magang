<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerusahaanMitra;
use Illuminate\Support\Facades\Http;

class PerusahaanMitraSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_perusahaan' => 'PT. Multi Spunindo Jaya, Tbk',
                'bidang_industri' => 'Manufaktur',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Krian, Sidoarjo, Jawa Timur',
                'email'           => 'info@spuindo.com',
                'telepon'         => '031-8975555',
            ],
            [
                'nama_perusahaan' => 'PT Lesaffre Sari Nusa',
                'bidang_industri' => 'Fermentasi',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Krebet, Bululawang, Kabupaten Malang, Jawa Timur 65163',
                'email'           => 'contact@lesaffre.co.id',
                'telepon'         => '0341-654321',
            ],
            [
                'nama_perusahaan' => 'PT. Satoria Aneka Industri',
                'bidang_industri' => 'Farmasi',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Wonorejo, Pasuruan, Jawa Timur 67173',
                'email'           => 'contact@satoria.co.id',
                'telepon'         => '0343-6752123',
            ],
            [
                'nama_perusahaan' => 'PT Rapidplast Indonesia',
                'bidang_industri' => 'Manufaktur',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Sukorejo, Pasuruan',
                'email'           => 'contact@rapidplast.co.id',
                'telepon'         => '0341-654321',
            ],
            [
                'nama_perusahaan' => 'PT. Amerta Indah Otsuka',
                'bidang_industri' => 'Farmasi',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Kejayan, Pasuruan, Jawa Timur 67172',
                'email'           => 'contact@otsuka.co.id',
                'telepon'         => '0343-414200',
            ],
            [
                'nama_perusahaan' => 'PT. Schneider Indonesia',
                'bidang_industri' => 'Elektronika',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Jakarta',
                'email'           => 'contact@schneider.co.id',
                'telepon'         => '021-8970203',
            ],
            [
                'nama_perusahaan' => 'PT. Borwita Citra Prima',
                'bidang_industri' => 'Layanan Distribusi',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Pakis, Kabupaten Malang, Jawa Timur',
                'email'           => 'contact@borwitacitra.co.id',
                'telepon'         => '031-7889777',
            ],
            [
                'nama_perusahaan' => 'PT. Bangun Arta Hutama',
                'bidang_industri' => 'Manufaktur',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Driyorejo, Kabupaten Gresik, Jawa Timur 61177',
                'email'           => 'contact@bangunarta.co.id',
                'telepon'         => '0341-654321',
            ],
            [
                'nama_perusahaan' => 'PT. Viktori Profindo Automation',
                'bidang_industri' => 'Supplier Peralatan Industri',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Semolowaru, Sukolilo, Surabaya, East Java 60119',
                'email'           => 'contact@viktori.co.id',
                'telepon'         => '031-5944555',
            ],
            [
                'nama_perusahaan' => 'Golden Tulip Holland Resort Batu',
                'bidang_industri' => 'Hotel',
                'id_jenis_perusahaan' => random_int(9, 12),
                'alamat'          => 'Temas, Batu, Jawa Timur 65314',
                'email'           => 'contact@goldentuliphollandresort.co.id',
                'telepon'         => '0341-3302000',
            ],
        ];

        foreach ($data as $item) {
            PerusahaanMitra::create([
                'nama_perusahaan' => $item['nama_perusahaan'],
                'bidang_industri' => $item['bidang_industri'],
                'id_jenis_perusahaan' => $item['id_jenis_perusahaan'],
                'alamat'          => $item['alamat'],
                'email'           => $item['email'],
                'telepon'         => $item['telepon'],
            ]);
        }
    }
}
