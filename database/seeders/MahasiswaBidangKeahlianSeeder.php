<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaBidangKeahlianSeeder extends Seeder
{

    public function run(): void
    {
        $mahasiswaBidangKeahlian = [
            ['nim' => '2341720172', 'id_bidang' => [1, 2]],
            ['nim' => '2341720182', 'id_bidang' => [14, 6, 21]],
            ['nim' => '2341720234', 'id_bidang' => [27, 18]],
            ['nim' => '2341720256', 'id_bidang' => [5, 13]],
            ['nim' => '2341720187', 'id_bidang' => [23, 7, 10]],
            ['nim' => '2341720038', 'id_bidang' => [12, 25]],
            ['nim' => '2341720232', 'id_bidang' => [19, 8, 3]],
            ['nim' => '2341720089', 'id_bidang' => [4, 26]],
            ['nim' => '2341720042', 'id_bidang' => [10, 17]],
            ['nim' => '2341720103', 'id_bidang' => [7, 29, 22]],
            ['nim' => '2341720157', 'id_bidang' => [16, 30]],
            ['nim' => '244107023001', 'id_bidang' => [29, 11, 5]],
            ['nim' => '2341720235', 'id_bidang' => [9, 24]],
            ['nim' => '2341720043', 'id_bidang' => [18, 1]],
            ['nim' => '2341720124', 'id_bidang' => [22, 3, 27]],
            ['nim' => '2341720194', 'id_bidang' => [3, 28]],
            ['nim' => '2341720099', 'id_bidang' => [28, 4]],
            ['nim' => '2341720024', 'id_bidang' => [6, 15, 23]],
            ['nim' => '2341720013', 'id_bidang' => [15, 2]],
            ['nim' => '2341720237', 'id_bidang' => [25, 17, 14]],
            ['nim' => '2341720230', 'id_bidang' => [2, 9]],
            ['nim' => '2341720167', 'id_bidang' => [11, 7, 13]],
            ['nim' => '2341720082', 'id_bidang' => [30, 10]],
            ['nim' => '2341720078', 'id_bidang' => [8, 12, 16]],
            ['nim' => '2341720163', 'id_bidang' => [1, 6]],
            ['nim' => '2341720029', 'id_bidang' => [20, 26]],
            ['nim' => '2341720062', 'id_bidang' => [13, 21, 19]],
            ['nim' => '2341720149', 'id_bidang' => [24, 5]],
            ['nim' => '2341720030', 'id_bidang' => [17, 20, 30]],
            ['nim' => '2341720018', 'id_bidang' => [26, 8]],
        ];


        foreach ($mahasiswaBidangKeahlian as $mhsBK) {
            
            $id = DB::table('users')->where('username', $mhsBK['nim'])->value('id_user');

            DB::table('mahasiswa_bidang_keahlian')->insert([
                'id_mahasiswa'          => $id,
                'id_bidang_keahlian'    => $mhsBK,
                'created_at'            => now(),
            ]);
        }
    }
}