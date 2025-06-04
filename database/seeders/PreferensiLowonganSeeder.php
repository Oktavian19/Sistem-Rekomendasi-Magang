<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiLowonganSeeder extends Seeder
{
    public function run(): void
    {
        $preferensiLowongan = [
            1 =>  [ 'fasilitas' => [44, 45, 47],     'bidang' => [14, 16, 18] ],
            2 =>  [ 'fasilitas' => [46, 48, 50],     'bidang' => [19, 21, 23] ],
            3 =>  [ 'fasilitas' => [49, 51, 53],     'bidang' => [24, 26, 28] ],
            4 =>  [ 'fasilitas' => [52, 54, 56],     'bidang' => [29, 31, 33] ],
            5 =>  [ 'fasilitas' => [55, 57, 59],     'bidang' => [34, 36, 38] ],
            6 =>  [ 'fasilitas' => [60, 44, 46],     'bidang' => [39, 41, 43] ],
            7 =>  [ 'fasilitas' => [45, 47, 49],     'bidang' => [15, 17, 19] ],
            8 =>  [ 'fasilitas' => [50, 52, 54],     'bidang' => [20, 22, 24] ],
            9 =>  [ 'fasilitas' => [56, 58, 60],     'bidang' => [25, 27, 29] ],
            10 => [ 'fasilitas' => [44, 48, 59],     'bidang' => [30, 32, 34] ],
            11 => [ 'fasilitas' => [45, 51, 55],     'bidang' => [35, 37, 39] ],
            12 => [ 'fasilitas' => [46, 53, 57],     'bidang' => [40, 42, 14] ],
            13 => [ 'fasilitas' => [47, 59, 44],     'bidang' => [15, 22, 31] ],
            14 => [ 'fasilitas' => [48, 60, 45],     'bidang' => [18, 25, 36] ],
            15 => [ 'fasilitas' => [49, 59, 46],     'bidang' => [21, 28, 38] ],
            16 => [ 'fasilitas' => [50, 44, 47],     'bidang' => [29, 33, 40] ],
            17 => [ 'fasilitas' => [51, 45, 48],     'bidang' => [17, 26, 35] ],
            18 => [ 'fasilitas' => [52, 46, 49],     'bidang' => [23, 32, 37] ],
            19 => [ 'fasilitas' => [53, 47, 50],     'bidang' => [19, 30, 41] ],
            20 => [ 'fasilitas' => [54, 48, 51],     'bidang' => [16, 27, 43] ],
        ];

        foreach ($preferensiLowongan as $idLowongan => $opsi) {
            foreach ($opsi['fasilitas'] as $idFasilitas) {
                DB::table('preferensi_lowongan')->insert([
                    'id_lowongan' => $idLowongan,
                    'id_opsi'     => $idFasilitas,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            foreach ($opsi['bidang'] as $idBidang) {
                DB::table('preferensi_lowongan')->insert([
                    'id_lowongan' => $idLowongan,
                    'id_opsi'     => $idBidang,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
