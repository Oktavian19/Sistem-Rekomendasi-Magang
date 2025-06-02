<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasLowonganSeeder extends Seeder
{
    /**
     * Generate random options from a range
     */
    private function generateRandomOptions($min, $max, $minRange, $maxRange) {
        $num_elements = rand($min, $max);
        $all_numbers = range($minRange, $maxRange);
        shuffle($all_numbers);
        return array_slice($all_numbers, 0, $num_elements);
    }

    public function run(): void
    {
        // Ambil range ID fasilitas (asumsi id_kategori=6 adalah fasilitas)
        $minFasilitasId = DB::table('opsi_preferensi')
                          ->where('id_kategori', 6)
                          ->min('id');
                          
        $maxFasilitasId = DB::table('opsi_preferensi')
                          ->where('id_kategori', 6)
                          ->max('id');

        // Ambil semua ID lowongan
        $lowonganIds = DB::table('lowongan')->pluck('id_lowongan')->toArray();

        if (empty($lowonganIds)) {
            $this->command->info('Tidak ada lowongan yang tersedia. Seeder fasilitas lowongan dilewati.');
            return;
        }

        foreach ($lowonganIds as $lowonganId) {
            // Generate 3-5 fasilitas acak untuk setiap lowongan
            $fasilitasIds = $this->generateRandomOptions(3, 5, $minFasilitasId, $maxFasilitasId);

            foreach ($fasilitasIds as $fasilitasId) {
                DB::table('fasilitas_lowongan')->insert([
                    'id_lowongan' => $lowonganId,
                    'id_fasilitas' => $fasilitasId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}