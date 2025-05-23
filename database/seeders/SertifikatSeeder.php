<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SertifikatSeeder extends Seeder
{
    public function run(): void
    {
        $sertifikat = [
            ['id_magang' => 1,  'path_sertifikat' => 'sertifikat/2341720024.pdf',  'status_sertifikat' => 'diterbitkan'],
            // ['id_magang' => 2,  'path_sertifikat' => 'sertifikat/sertifikat_2.pdf',  'status_sertifikat' => 'diterbitkan'],
            // ['id_magang' => 3,  'path_sertifikat' => 'sertifikat/sertifikat_3.pdf',  'status_sertifikat' => 'diproses'],
            // ['id_magang' => 4,  'path_sertifikat' => null,                           'status_sertifikat' => 'belum'],
            // ['id_magang' => 5,  'path_sertifikat' => null,                           'status_sertifikat' => 'belum'],
            // ['id_magang' => 6,  'path_sertifikat' => 'sertifikat/sertifikat_6.pdf',  'status_sertifikat' => 'diterbitkan'],
            // ['id_magang' => 7,  'path_sertifikat' => 'sertifikat/sertifikat_7.pdf',  'status_sertifikat' => 'diproses'],
            // ['id_magang' => 8,  'path_sertifikat' => null,                           'status_sertifikat' => 'belum'],
            // ['id_magang' => 9,  'path_sertifikat' => 'sertifikat/sertifikat_9.pdf',  'status_sertifikat' => 'diterbitkan'],
            // ['id_magang' => 10, 'path_sertifikat' => 'sertifikat/sertifikat_10.pdf', 'status_sertifikat' => 'diproses'],
            // ['id_magang' => 11, 'path_sertifikat' => null,                           'status_sertifikat' => 'belum'],
            // ['id_magang' => 12, 'path_sertifikat' => 'sertifikat/sertifikat_12.pdf', 'status_sertifikat' => 'diterbitkan'],
            // ['id_magang' => 13, 'path_sertifikat' => 'sertifikat/sertifikat_13.pdf', 'status_sertifikat' => 'diproses'],
            // ['id_magang' => 14, 'path_sertifikat' => null,                           'status_sertifikat' => 'belum'],
            // ['id_magang' => 15, 'path_sertifikat' => 'sertifikat/sertifikat_15.pdf', 'status_sertifikat' => 'diterbitkan'],
        ];

        foreach ($sertifikat as $data) {
            DB::table('sertifikat')->insert([
                'id_magang'         => $data['id_magang'],
                'path_sertifikat'   => $data['path_sertifikat'],
                'status_sertifikat' => $data['status_sertifikat'],
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
        }
    }
}
