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
                'nama_perusahaan' => 'PT Nusantara Teknologi',
                'bidang_industri' => 'Teknologi Informasi',
                'alamat'          => 'Malang, Jawa Timur',
                'email'           => 'info@nusantarateknologi.com',
                'telepon'         => '0341-123456',
            ],
            [
                'nama_perusahaan' => 'CV Maju Jaya',
                'bidang_industri' => 'Manufaktur',
                'alamat'          => 'Surabaya, Jawa Timur',
                'email'           => 'contact@majujaya.co.id',
                'telepon'         => '0341-654321',
            ],
            // Tambahkan data perusahaan lainnya sesuai kebutuhan
        ];

        foreach ($data as $item) {
            $geo = $this->getCoordinates($item['alamat']);

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
