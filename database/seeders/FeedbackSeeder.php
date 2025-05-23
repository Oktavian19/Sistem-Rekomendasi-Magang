<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $feedbacks = [
            [ 'nim' => '2341720187', 'id_magang' => 1, 'komentar' => 'Magang sangat bermanfaat dan menambah pengalaman.', 'rating' => 5, 'tanggal_feedback' => '2025-05-10' ],
            [ 'nim' => '2341720235', 'id_magang' => 2, 'komentar' => 'Lingkungan kerja sangat mendukung untuk belajar.', 'rating' => 4, 'tanggal_feedback' => '2025-05-11' ],
            [ 'nim' => '2341720157', 'id_magang' => 3, 'komentar' => 'Cukup baik, namun bimbingan masih bisa ditingkatkan.', 'rating' => 3, 'tanggal_feedback' => '2025-05-12' ],
            [ 'nim' => '2341720042', 'id_magang' => 4, 'komentar' => 'Pengalaman sangat berkesan, mentor sangat membantu.', 'rating' => 5, 'tanggal_feedback' => '2025-05-13' ],
            [ 'nim' => '2341720103', 'id_magang' => 5, 'komentar' => 'Magang bagus, tetapi waktunya terasa singkat.', 'rating' => 4, 'tanggal_feedback' => '2025-05-14' ],
        ];

        foreach ($feedbacks as $fb) {
            $idUser = DB::table('users')->where('username', $fb['nim'])->value('id_user');

            if ($idUser) {
                DB::table('feedback')->insert([
                    'id_user'          => $idUser,
                    'id_magang'        => $fb['id_magang'],
                    'komentar'         => $fb['komentar'],
                    'rating'           => $fb['rating'],
                    'tanggal_feedback' => $fb['tanggal_feedback'],
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now(),
                ]);
            }
        }
    }
}
