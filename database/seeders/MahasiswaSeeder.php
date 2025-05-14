<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'id_user' => '2',
                'nim' => '2341720172',
                'nama' => 'ACHMAD MAULANA HAMZAH',
                'email' => '2341720172@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '3',
                'nim' => '2341720182',
                'nama' => 'ALVANZA SAPUTRA YUDHA',
                'email' => '2341720182@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '4',
                'nim' => '2341720234',
                'nama' => 'ANYA CALLISSTA CHRISWANTARI',
                'email' => '2341720234@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '5',
                'nim' => '2341720256',
                'nama' => 'BERYL FUNKY MUBAROK',
                'email' => '2341720256@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '6',
                'nim' => '2341720187',
                'nama' => 'CANDRA AHMAD DANI',
                'email' => '2341720187@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '7',
                'nim' => '2341720038',
                'nama' => 'CINDY LAILI LARASATI',
                'email' => '2341720038@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '8',
                'nim' => '2341720232',
                'nama' => 'DIKA ARIE ARRIFKY',
                'email' => '2341720232@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '9',
                'nim' => '2341720089',
                'nama' => 'FAHMI YAHYA',
                'email' => '2341720089@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '10',
                'nim' => '2341720042',
                'nama' => 'GILANG PURNOMO',
                'email' => '@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '11',
                'nim' => '2341720103',
                'nama' => 'GWIDO PUTRA WIJAYA',
                'email' => 'gwido.putra@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '12',
                'nim' => '2341720157',
                'nama' => 'HIDAYAT WIDI SAPUTRA',
                'email' => 'hidayat.widi@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '13',
                'nim' => '244107023001',
                'nama' => 'ILHAM FATURACHMAN',
                'email' => 'ilham.faturachman@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '14',
                'nim' => '2341720235',
                'nama' => 'INNAMA MAESA PUTRI',
                'email' => 'innama.maesa@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '15',
                'nim' => '2341720043',
                'nama' => 'JIHA RAMDHAN',
                'email' => 'jiha.ramadhan@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '16',
                'nim' => '2341720124',
                'nama' => 'LELYTA MEYDA AYU BUDIYANTI',
                'email' => 'lelyta.meyda@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '17',
                'nim' => '2341720194',
                'nama' => 'M. FATIHI AL GHIFARY',
                'email' => 'fatihi.ghifary@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '18',
                'nim' => '2341720099',
                'nama' => 'M. FIRMANSYAH',
                'email' => 'firmansyah@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '19',
                'nim' => '2341720024',
                'nama' => 'MOCH. ALFIN BURHANUDIN ALQODRI',
                'email' => 'alfin.burhanudin@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '20',
                'nim' => '2341720013',
                'nama' => 'MUHAMAD SYAIFULLAH',
                'email' => 'muhamad.syaifullah@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '21',
                'nim' => '2341720237',
                'nama' => 'MUHAMMAD NUR AZIZ',
                'email' => 'nur.aziz@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '22',
                'nim' => '2341720230',
                'nama' => 'NAJWA ALYA NURIZZAH',
                'email' => 'najwa.alya@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '23',
                'nim' => '2341720167',
                'nama' => 'NECHA SYIFA SYAFITRI',
                'email' => 'necha.syifa@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '24',
                'nim' => '2341720082',
                'nama' => 'NOKLENT FARDIAN ERIX',
                'email' => 'noklent.erix@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '25',
                'nim' => '2341720078',
                'nama' => 'OCTRIAN ADILUHUNG TITO PUTRA',
                'email' => 'octrian.putra@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '26',
                'nim' => '2341720163',
                'nama' => 'SATRIO AHMAD RAMADHANI',
                'email' => 'satrio.ramadhani@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '27',
                'nim' => '2341720029',
                'nama' => 'SESY TANA LINA RAHMATIN',
                'email' => 'sesy.rahmatin@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '28',
                'nim' => '2341720062',
                'nama' => 'TAUFIK DIMAS EDYSTARA',
                'email' => 'taufik.edystara@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '29',
                'nim' => '2341720149',
                'nama' => 'VINCENTIUS LEONANDA PRABOWO',
                'email' => 'vincentius.prabowo@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '30',
                'nim' => '2341720030',
                'nama' => 'YANUAR RIZKI AMINUDIN',
                'email' => 'yanuar.aminudin@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ],
            [
                'id_user' => '31',
                'nim' => '2341720018',
                'nama' => 'ABDILLAH NOER SAID',
                'email' => 'abdillah.noer@example.com',
                'no_hp' => '081234567890',
                'id_program_studi' => 1
            ]
        ]);
    }
}
