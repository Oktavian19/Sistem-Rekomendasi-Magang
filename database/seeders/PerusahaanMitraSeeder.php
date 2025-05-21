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
                'alamat'          => 'Krian, Sidoarjo, Jawa Timur',
                'email'           => 'info@spuindo.com',
                'telepon'         => '031-8975555',
            ],
            [
                'nama_perusahaan' => 'PT Lesaffre Sari Nusa',
                'bidang_industri' => 'Fermentasi',
                'alamat'          => 'Krebet, Bululawang, Kabupaten Malang, Jawa Timur 65163',
                'email'           => 'contact@lesaffre.co.id',
                'telepon'         => '0341-654321',
            ],
            [
                'nama_perusahaan' => 'PT. Satoria Aneka Industri',
                'bidang_industri' => 'Farmasi',
                'alamat'          => 'Wonorejo, Pasuruan, Jawa Timur 67173',
                'email'           => 'contact@satoria.co.id',
                'telepon'         => '0343-6752123',
            ],
            [
                'nama_perusahaan' => 'PT Rapidplast Indonesia',
                'bidang_industri' => 'Manufaktur',
                'alamat'          => 'Sukorejo, Pasuruan',
                'email'           => 'contact@rapidplast.co.id',
                'telepon'         => '0341-654321',
            ],
            [
                'nama_perusahaan' => 'PT. Amerta Indah Otsuka',
                'bidang_industri' => 'Farmasi',
                'alamat'          => 'Kejayan, Pasuruan, Jawa Timur 67172',
                'email'           => 'contact@otsuka.co.id',
                'telepon'         => '0343-414200',
            ],
            [
                'nama_perusahaan' => 'PT. Schneider Indonesia',
                'bidang_industri' => 'Elektronika',
                'alamat'          => 'Jakarta',
                'email'           => 'contact@schneider.co.id',
                'telepon'         => '021-8970203',
            ],
            [
                'nama_perusahaan' => 'PT. Borwita Citra Prima',
                'bidang_industri' => 'Layanan Distribusi',
                'alamat'          => 'Pakis, Kabupaten Malang, Jawa Timur',
                'email'           => 'contact@borwitacitra.co.id',
                'telepon'         => '031-7889777',
            ],
            [
                'nama_perusahaan' => 'PT. Bangun Arta Hutama',
                'bidang_industri' => 'Manufaktur',
                'alamat'          => 'Driyorejo, Kabupaten Gresik, Jawa Timur 61177',
                'email'           => 'contact@bangunarta.co.id',
                'telepon'         => '0341-654321',
            ],
            [
                'nama_perusahaan' => 'PT. Viktori Profindo Automation',
                'bidang_industri' => 'Supplier Peralatan Industri',
                'alamat'          => 'Semolowaru, Sukolilo, Surabaya, East Java 60119',
                'email'           => 'contact@viktori.co.id',
                'telepon'         => '031-5944555',
            ],
            [
                'nama_perusahaan' => 'Golden Tulip Holland Resort Batu',
                'bidang_industri' => 'Hotel',
                'alamat'          => 'Temas, Batu, Jawa Timur 65314',
                'email'           => 'contact@goldentuliphollandresort.co.id',
                'telepon'         => '0341-3302000',
            ],
        ];

        foreach ($data as $item) {
            $geo = $this->getCoordinates($item['alamat']);
            sleep(1);

            PerusahaanMitra::create([
                'nama_perusahaan' => $item['nama_perusahaan'],
                'bidang_industri' => $item['bidang_industri'],
                'alamat'          => $item['alamat'],
                'email'           => $item['email'],
                'telepon'         => $item['telepon'],
                'latitude'        => $geo['lat'] ?? null,
                'longitude'       => $geo['lon'] ?? null,
            ]);
        }
    }

    private function getCoordinates($alamat)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'LaravelSeeder/1.0 (your.email@example.com)',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $alamat,
            'format' => 'json',
            'limit' => 1,
        ]);

        if ($response->successful() && !empty($response[0])) {
            return [
                'lat' => $response[0]['lat'],
                'lon' => $response[0]['lon'],
            ];
        }

        return null;
    }
}
