<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DokumenLogKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $dokumen = [
            ['id_log' => 1,  'file' => 'Review kode dengan tim.pdf'],
            // ['id_log' => 2,  'file' => 'kegiatan_2_absensi.jpg'],
            // ['id_log' => 3,  'file' => 'kegiatan_3_foto1.jpg'],
            // ['id_log' => 4,  'file' => 'kegiatan_4_laporan_final.docx'],
            // ['id_log' => 5,  'file' => 'kegiatan_5_lampiran.zip'],
            // ['id_log' => 6,  'file' => 'kegiatan_6_catatan.pdf'],
            // ['id_log' => 7,  'file' => 'kegiatan_7_screenshot1.png'],
            // ['id_log' => 8,  'file' => 'kegiatan_8_rangkuman.docx'],
            // ['id_log' => 9,  'file' => 'kegiatan_9_poster.jpg'],
            // ['id_log' => 10, 'file' => 'kegiatan_10_evaluasi.pdf'],
        ];

        foreach ($dokumen as $doc) {
            DB::table('dokumen_log_kegiatan')->insert([
                'id_log'     => $doc['id_log'],
                'path_file'           => $doc['file'],
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}
