<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class MahasiswaSeeder extends Seeder
{

    public function run(): void
    {
        $mahasiswa = [
            ['nim' => '2341720172', 'nama' => 'ACHMAD MAULANA HAMZAH', 'preferensi_lokasi' => 'Purwokerto'],
            ['nim' => '2341720182', 'nama' => 'ALVANZA SAPUTRA YUDHA'],
            ['nim' => '2341720234', 'nama' => 'ANYA CALLISSTA CHRISWANTARI'],
            ['nim' => '2341720256', 'nama' => 'BERYL FUNKY MUBAROK'],
            ['nim' => '2341720187', 'nama' => 'CANDRA AHMAD DANI'],
            ['nim' => '2341720038', 'nama' => 'CINDY LAILI LARASATI'],
            ['nim' => '2341720232', 'nama' => 'DIKA ARIE ARRIFKY'],
            ['nim' => '2341720089', 'nama' => 'FAHMI YAHYA'],
            ['nim' => '2341720042', 'nama' => 'GILANG PURNOMO'],
            ['nim' => '2341720103', 'nama' => 'GWIDO PUTRA WIJAYA'],
            ['nim' => '2341720157', 'nama' => 'HIDAYAT WIDI SAPUTRA'],
            ['nim' => '244107023001', 'nama' => 'ILHAM FATURACHMAN'],
            ['nim' => '2341720235', 'nama' => 'INNAMA MAESA PUTRI'],
            ['nim' => '2341720043', 'nama' => 'JIHA RAMDHAN'],
            ['nim' => '2341720124', 'nama' => 'LELYTA MEYDA AYU BUDIYANTI'],
            ['nim' => '2341720194', 'nama' => 'M. FATIHI AL GHIFARY'],
            ['nim' => '2341720099', 'nama' => 'M. FIRMANSYAH'],
            ['nim' => '2341720024', 'nama' => 'MOCH. ALFIN BURHANUDIN ALQODRI'],
            ['nim' => '2341720013', 'nama' => 'MUHAMAD SYAIFULLAH'],
            ['nim' => '2341720237', 'nama' => 'MUHAMMAD NUR AZIZ'],
            ['nim' => '2341720230', 'nama' => 'NAJWA ALYA NURIZZAH'],
            ['nim' => '2341720167', 'nama' => 'NECHA SYIFA SYAFITRI'],
            ['nim' => '2341720082', 'nama' => 'NOKLENT FARDIAN ERIX'],
            ['nim' => '2341720078', 'nama' => 'OCTRIAN ADILUHUNG TITO PUTRA'],
            ['nim' => '2341720163', 'nama' => 'SATRIO AHMAD RAMADHANI'],
            ['nim' => '2341720029', 'nama' => 'SESY TANA LINA RAHMATIN'],
            ['nim' => '2341720062', 'nama' => 'TAUFIK DIMAS EDYSTARA'],
            ['nim' => '2341720149', 'nama' => 'VINCENTIUS LEONANDA PRABOWO'],
            ['nim' => '2341720030', 'nama' => 'YANUAR RIZKI AMINUDIN'],
            ['nim' => '2341720018', 'nama' => 'ABDILLAH NOER SAID']
        ];


        foreach ($mahasiswa as $mhs) {
            // Tambahkan user
            DB::table('users')->insert([
                'username' => $mhs['nim'],
                'password' => Hash::make($mhs['nim']),
                'role' => 'mahasiswa',
                'created_at' => now(),
            ]);

            $id = DB::table('users')->where('username', $mhs['nim'])->value('id_user');

            // Cek dan ambil preferensi lokasi jika ada
            $lokasi = $mhs['preferensi_lokasi'] ?? null;
            $geo = $lokasi ? $this->getCoordinates($lokasi) : null;

            // Masukkan ke tabel mahasiswa
            DB::table('mahasiswa')->insert([
                'id_mahasiswa' => $id,
                'nim' => $mhs['nim'],
                'nama' => $mhs['nama'],
                'id_program_studi' => 1,
                'preferensi_lokasi' => $lokasi,
                'latitude' => $geo['lat'] ?? null,
                'longitude' => $geo['lon'] ?? null,
                'created_at' => now(),
            ]);
        }
    }

    private function getCoordinates($preferensi_lokasi)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'LaravelSeeder/1.0 (your.email@example.com)',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $preferensi_lokasi,
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
