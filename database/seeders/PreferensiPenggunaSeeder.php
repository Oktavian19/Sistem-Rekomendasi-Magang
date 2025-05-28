<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiPenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $bidang = [
            ['nim' => '2341720172', 'id_opsi' => [14, 15],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720182', 'id_opsi' => [27, 19, 34],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720234', 'id_opsi' => [40, 31],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720256', 'id_opsi' => [18, 26],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720187', 'id_opsi' => [36, 20, 23],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720038', 'id_opsi' => [25, 38],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720232', 'id_opsi' => [32, 21, 16],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720089', 'id_opsi' => [17, 39],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720042', 'id_opsi' => [23, 30],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720103', 'id_opsi' => [20, 42, 35],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720157', 'id_opsi' => [29, 43],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '244107023001', 'id_opsi' => [42, 24, 18],'ranking' => [1, 2, 3],'poin' => [15, 10, 5] ],
            ['nim' => '2341720235', 'id_opsi' => [22, 37],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720043', 'id_opsi' => [31, 14],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720124', 'id_opsi' => [35, 16, 40],'ranking' => [1, 2, 3] , 'poin' => [15, 10, 5] ],
            ['nim' => '2341720194', 'id_opsi' => [16, 41],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720099', 'id_opsi' => [41, 17],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720024', 'id_opsi' => [19, 28, 36],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720013', 'id_opsi' => [28, 15],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720237', 'id_opsi' => [38, 30, 27],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720230', 'id_opsi' => [15, 22],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720167', 'id_opsi' => [24, 20, 26],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720082', 'id_opsi' => [43, 23],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720078', 'id_opsi' => [21, 25, 29],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720163', 'id_opsi' => [14, 19],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720029', 'id_opsi' => [33, 39],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720062', 'id_opsi' => [26, 34, 32],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720149', 'id_opsi' => [37, 18],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
            ['nim' => '2341720030', 'id_opsi' => [30, 33, 43],'ranking' => [1, 2, 3] ,'poin' => [15, 10, 5] ],
            ['nim' => '2341720018', 'id_opsi' => [39, 21],    'ranking' => [1, 2] ,   'poin' => [10, 5] ],
        ];

        foreach ($bidang as $mhsBK) {
            
            $id = DB::table('users')->where('username', $mhsBK['nim'])->value('id_user');

                foreach ($mhsBK['id_opsi'] as $index => $id_opsi) {
                    DB::table('preferensi_pengguna')->insert([
                        'id_mahasiswa' => $id,
                        'id_opsi'      => $id_opsi,
                        'ranking'      => $mhsBK['ranking'][$index],
                        'poin'         => $mhsBK['poin'][$index],
                        'created_at'   => now(),
                    ]);
                }
        }
    }
}
