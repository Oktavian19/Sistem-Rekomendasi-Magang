<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DokumenSeeder extends Seeder
{
    public function run(): void
    {
        $daftarDokumen = [
            ['nim' => '2341720172', 'jenis' => 'Curriculum Vitae (CV)', 'file' => '2341720172.pdf'],
            // ['nim' => '2341720182', 'jenis' => 'Sertifikat'],
            // ['nim' => '2341720234', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720256', 'jenis' => 'surat_pengantar'],
            // ['nim' => '2341720187', 'jenis' => 'lainnya'],
            // ['nim' => '2341720038', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720232', 'jenis' => 'Sertifikat'],
            // ['nim' => '2341720089', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720042', 'jenis' => 'lainnya'],
            // ['nim' => '2341720103', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720157', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '244107023001', 'jenis' => 'Sertifikat'],
            // ['nim' => '2341720235', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720043', 'jenis' => 'lainnya'],
            // ['nim' => '2341720124', 'jenis' => 'surat_pengantar'],
            // ['nim' => '2341720194', 'jenis' => 'Sertifikat'],
            // ['nim' => '2341720099', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720024', 'jenis' => 'lainnya'],
            // ['nim' => '2341720013', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720237', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720230', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720167', 'jenis' => 'surat_pengantar'],
            // ['nim' => '2341720082', 'jenis' => 'lainnya'],
            // ['nim' => '2341720078', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720163', 'jenis' => 'Sertifikat'],
            // ['nim' => '2341720029', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720062', 'jenis' => 'lainnya'],
            // ['nim' => '2341720149', 'jenis' => 'Curriculum Vitae (CV)'],
            // ['nim' => '2341720030', 'jenis' => 'Sertifikat'],
            // ['nim' => '2341720018', 'jenis' => 'Curriculum Vitae (CV)'],
        ];

        foreach ($daftarDokumen as $dokumen) {
            $id_user = DB::table('users')->where('username', $dokumen['nim'])->value('id_user');

            if ($id_user) {
                DB::table('dokumen')->insert([
                    'id_user'        => $id_user,
                    'jenis_dokumen'  => $dokumen['jenis'],
                    'path_file'      => 'dokumen/' . $dokumen['file'],
                    'tanggal_upload' => now()->subDays(rand(1, 30)),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}