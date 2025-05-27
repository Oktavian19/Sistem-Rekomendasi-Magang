<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpsiPreferensiSeeder extends Seeder
{
    public function run(): void
    {
        $jarak = [
            ['kode' => 'dalam_kota',    'label' => 'Dalam Kota',    ],
            ['kode' => 'luar_kota',     'label' => 'Luar Kota',     ],
            ['kode' => 'luar_provinsi', 'label' => 'Luar Provinsi' ],
        ];

        $durasi = [
            ['kode' => '3_bulan','label' => '3 Bulan'],
            ['kode' => '6_bulan','label' => '6 Bulan'],
        ];

        $pelaksanaan = [
            ['kode' => 'wfo',    'label' => 'WFO',   ],
            ['kode' => 'wfh',    'label' => 'WFH',   ],
            ['kode' => 'hybrid', 'label' => 'Hybrid' ],
        ];

        $perusahaan = [
            ['kode' => 'bumn',       'label' => 'Badan Usaha Milik Negara',],
            ['kode' => 'pemerintah', 'label' => 'Pemerintah',],
            ['kode' => 'startup',    'label' => 'Startup'],
            ['kode' => 'studio',     'label' => 'Studio'],
            ['kode' => 'sh',         'label' => 'Software House'],
        ];

        $bidang = [
            ['kode' => 'BE',    'label' => 'Backend Development',    ],
            ['kode' => 'FE',    'label' => 'Frontend Development',   ],
            ['kode' => 'FS',    'label' => 'Full-Stack Development', ],
            ['kode' => 'DO',    'label' => 'DevOps Engineering',     ],
            ['kode' => 'MD',    'label' => 'Mobile Development',     ],
            ['kode' => 'GD',    'label' => 'Game Development',       ],
            ['kode' => 'DS',    'label' => 'Data Science',           ],
            ['kode' => 'AI',    'label' => 'Artificial Intelligence',],
            ['kode' => 'ML',    'label' => 'Machine Learning',       ],
            ['kode' => 'SEC',   'label' => 'Cybersecurity',          ],
            ['kode' => 'CC',    'label' => 'Cloud Computing',        ],
            ['kode' => 'QA',    'label' => 'Quality Assurance',      ],
            ['kode' => 'DBA',   'label' => 'Database Administration',],
            ['kode' => 'BC',    'label' => 'Blockchain Development', ],
            ['kode' => 'ES',    'label' => 'Embedded Systems',       ],
            ['kode' => 'UX',    'label' => 'UI/UX Design',           ],
            ['kode' => 'SA',    'label' => 'Systems Architecture',   ],
            ['kode' => 'API',   'label' => 'API Development',        ],
            ['kode' => 'IOT',   'label' => 'IoT Engineering',        ],
            ['kode' => 'CV',    'label' => 'Computer Vision',        ],
            ['kode' => 'DM',    'label' => 'Digital Marketing',      ],
            ['kode' => 'TW',    'label' => 'Technical Writing',      ],
            ['kode' => 'PM',    'label' => 'Project Management',     ],
            ['kode' => 'PRM',   'label' => 'Product Management',     ],
            ['kode' => 'BA',    'label' => 'Business Analysis',      ],
            ['kode' => 'CCRT',  'label' => 'Content Creation',       ],
            ['kode' => 'GDG',   'label' => 'Graphic Design',         ],
            ['kode' => 'SMM',   'label' => 'Social Media Management',],
            ['kode' => 'DA',    'label' => 'Data Analysis',          ],
            ['kode' => 'HRIT',  'label' => 'Human Resources IT',     ]
        ];

        $fasilitas = [
            ['kode' => 'gaji',                              'label' => 'Gaji'],
            ['kode' => 'tunjangan_transportasi',            'label' => 'Tunjangan Transportasi'],
            ['kode' => 'tunjangan_makan',                   'label' => 'Tunjangan Makan'],
            ['kode' => 'bonus_insentif_kerja',              'label' => 'Bonus/Insentif Kerja'],
            ['kode' => 'penginapan_mess',                   'label' => 'Penginapan/Mess'],
            ['kode' => 'transportasi_antar_jemput',         'label' => 'Transportasi Antar-Jemput'],
            ['kode' => 'sertifikat_resmi',                  'label' => 'Sertifikat Resmi'],
            ['kode' => 'akses_library_software_berbayar',   'label' => 'Akses Library dan Software Berbayar'],
            ['kode' => 'surat_rekomendasi',                 'label' => 'Surat Rekomendasi'],
            ['kode' => 'letter_of_completion',              'label' => 'Letter of Completion'],
            ['kode' => 'proyek_nyata',                      'label' => 'Proyek Nyata'],
            ['kode' => 'asuransi_kesehatan',                'label' => 'Asuransi Kesehatan'],
            ['kode' => 'fasilitas_kebugaran',               'label' => 'Fasilitas Kebugaran'],
            ['kode' => 'ruang_istirahat_hiburan',           'label' => 'Ruang Istirahat dan Hiburan'],
            ['kode' => 'merchandise_perusahaan',            'label' => 'Merchandise Perusahaan'],
            ['kode' => 'program_volunteer',                 'label' => 'Program Volunteer'],
            ['kode' => 'access_to_alumni_network',          'label' => 'Access to Alumni Network'],
        ];


        foreach ($jarak as $j) {
            DB::table('opsi_preferensi')->insert([
                    'id_kategori' => 1,
                    'kode'  => $j['kode'],
                    'label' => $j['label'],
                    'created_at' => now(),
            ]);
        }

        foreach ($durasi as $d) {
            DB::table('opsi_preferensi')->insert([
                    'id_kategori' => 2,
                    'kode'  => $d['kode'],
                    'label' => $d['label'],
                    'created_at' => now(),
            ]);
        }

        foreach ($pelaksanaan as $pel) {
            DB::table('opsi_preferensi')->insert([
                    'id_kategori' => 3,
                    'kode'  => $pel['kode'],
                    'label' => $pel['label'],
                    'created_at' => now(),
            ]);
        }

        foreach ($perusahaan as $per) {
            DB::table('opsi_preferensi')->insert([
                    'id_kategori' => 4,
                    'kode'  => $per['kode'],
                    'label' => $per['label'],
                    'created_at' => now(),
            ]);
        }

        foreach ($bidang as $b) {
            DB::table('opsi_preferensi')->insert([
                    'id_kategori' => 5,
                    'kode'  => $b['kode'],
                    'label' => $b['label'],
                    'created_at' => now(),
            ]);
        }

        foreach ($fasilitas as $f) {
            DB::table('opsi_preferensi')->insert([
                    'id_kategori' => 6,
                    'kode'  => $f['kode'],
                    'label' => $f['label'],
                    'created_at' => now(),
            ]);
        }
    }
}
