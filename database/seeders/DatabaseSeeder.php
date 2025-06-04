<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KategoriPreferensiSeeder::class,
            OpsiPreferensiSeeder::class,
            ProgramStudiSeeder::class,
            PerusahaanMitraSeeder::class,
            PeriodeMagangSeeder::class,
            AdminSeeder::class,
            MahasiswaSeeder::class,
            DosenPembimbingSeeder::class,
            PengalamanSeeder::class,
            DokumenSeeder::class,
            LowonganSeeder::class,
            PreferensiLowonganSeeder::class,
            LamaranSeeder::class,
            MagangSeeder::class,
            LogKegiatanSeeder::class,
            FeedbackSeeder::class,
            DokumenLogKegiatanSeeder::class,
            PreferensiPenggunaSeeder::class,
        ]);
    }
}
