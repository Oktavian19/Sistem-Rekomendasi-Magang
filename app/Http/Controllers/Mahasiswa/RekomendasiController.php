<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mahasiswa\PreferensiController;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{

    public function index()
    {
        $idMahasiswa = auth()->user()->mahasiswa->id_mahasiswa;

        $alternatif =$this->generateMatriksAlternatif($idMahasiswa);

        $kriteria = [
            'Jarak',
            'Durasi Magang',
            'Jenis Pelaksanaan',
            'Jenis Perusahaan',
            'Bidang Keahlian',
            'Fasilitas'
        ];
        $bobot = $this->bobotCRITIC($alternatif);
        $hasil = $this->hitungWASPAS($alternatif, $bobot);

        return view('mahasiswa.rekomendasi.index', compact('kriteria', 'bobot', 'hasil'));
    }

    private function normalisasiMinMax($data)
    {
        $normal = [];
        $jumlah = count(current($data));

        for ($j = 0; $j < $jumlah; $j++) {
            // Cari nilai min dan max pada kolom ke-j
            $min = INF;
            $max = -INF;
            foreach ($data as $alt) {
                if ($alt[$j] < $min) $min = $alt[$j];
                if ($alt[$j] > $max) $max = $alt[$j];
            }

            foreach ($data as $key => $alt) {
                if ($max - $min == 0) {
                    $normal[$key][$j] = 0; // Hindari pembagian nol
                } else {
                    $normal[$key][$j] = ($alt[$j] - $min) / ($max - $min);
                }
            }
        }

        return $normal;
    }


    private function stddevSample($array)
    {
        $mean = array_sum($array) / count($array);
        $n = count($array);
        if ($n <= 1) return 0; // Hindari pembagian nol
        $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $array)) / ($n - 1);
        return sqrt($variance);
    }


    private function korelasiPearson($col1, $col2)
    {
        $mean1 = array_sum($col1) / count($col1);
        $mean2 = array_sum($col2) / count($col2);

        $num = 0;
        $den1 = 0;
        $den2 = 0;
        for ($i = 0; $i < count($col1); $i++) {
            $num += ($col1[$i] - $mean1) * ($col2[$i] - $mean2);
            $den1 += pow($col1[$i] - $mean1, 2);
            $den2 += pow($col2[$i] - $mean2, 2);
        }
        return $num / sqrt($den1 * $den2);
    }

    private function bobotCRITIC($data)
    {
        $normal = $this->normalisasiMinMax($data);
        $transpose = array_map(null, ...array_values($normal));
        $sigma = array_map([$this, 'stddevSample'], $transpose);
        $m = count($transpose);

        $C = [];
        for ($j = 0; $j < $m; $j++) {
            $sumCorr = 0;
            for ($k = 0; $k < $m; $k++) {
                if ($j !== $k) {
                    $sumCorr += (1 - abs($this->korelasiPearson($transpose[$j], $transpose[$k])));
                }
            }
            $C[$j] = $sigma[$j] * $sumCorr;
        }

        $totalC = array_sum($C);

        $weights = array_map(fn($c) => $c / $totalC, $C);

        return $weights;
    }

    private function normalisasiBenefit($data)
    {
        $max = [];
        for ($j = 0; $j < count(current($data)); $j++) {
            $max[$j] = max(array_column($data, $j));
        }

        $normal = [];
        foreach ($data as $key => $alt) {
            for ($j = 0; $j < count($alt); $j++) {
                $normal[$key][$j] = $alt[$j] / $max[$j];
            }
        }
        return $normal;
    }

    private function hitungWASPAS($data, $weights, $lambda = 0.5)
    {
        $normal = $this->normalisasiBenefit($data);
        $result = [];

        foreach ($normal as $key => $alt) {
            $WSM = 0;
            $WPM = 1;
            foreach ($alt as $j => $xij) {
                $WSM += $weights[$j] * $xij;
                $WPM *= pow($xij, $weights[$j]);
            }
            $Q = $lambda * $WSM + (1 - $lambda) * $WPM;
            $result[$key] = round($Q, 4);
        }

        arsort($result);
        return $result;
    }
}
