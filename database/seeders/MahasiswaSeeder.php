<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{

    public function run(): void
    {
        $mahasiswa = [
            ['nim' => '2341720172', 'nama' => 'ACHMAD MAULANA HAMZAH'],
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
            ['nim' => '2341720018', 'nama' => 'ABDILLAH NOER SAID' ]
        ];
        
        
        foreach ($mahasiswa as $mhs) {
            DB::table('users')->insert([
                    'username'  => $mhs['nim'],
                    'password'  => Hash::make($mhs['nim']),
                    'role' => 'mahasiswa',
                    'created_at' => now(),
            ]);

            $id = DB::table('users')->where('username', $mhs['nim'])->value('id_user');
            
            DB::table('mahasiswa')->insert([
                    'id_mahasiswa'  => $id,
                    'nim'           => $mhs['nim'],
                    'nama'          => $mhs['nama'],
                    'program_studi' => 1,
                    'created_at'    => now(),
            ]);
        }
    }
}