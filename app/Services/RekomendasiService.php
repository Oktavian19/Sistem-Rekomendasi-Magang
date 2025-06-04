<?php

namespace App\Services;

use App\Models\Lowongan;
use App\Models\OpsiPreferensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RekomendasiService
{
    public function generateMatriksAlternatif(int $idMahasiswa): array
    {
        return Lowongan::with('perusahaan')
            ->get()
            ->mapWithKeys(function (Lowongan $lowongan) use ($idMahasiswa) {
                $preferensi = $this->getPreferensiMahasiswa($idMahasiswa);

                return [
                    $lowongan->id_lowongan => [
                        $this->getSkorJarak($preferensi, $lowongan),
                        $this->getSkorDurasi($preferensi, $lowongan),
                        $this->getSkorPelaksanaan($preferensi, $lowongan),
                        $this->getSkorJenisPerusahaan($preferensi, $lowongan),
                        $this->getSkorBidangKeahlian($preferensi, $lowongan),
                        $this->getSkorFasilitas($preferensi, $lowongan)

                    ]
                ];
            })
            ->all();
    }


    protected function getPreferensiMahasiswa(int $idMahasiswa): array
    {
        $preferensi = DB::table('preferensi_pengguna as pp')
            ->join('opsi_preferensi as op', 'pp.id_opsi', '=', 'op.id')
            ->where('pp.id_mahasiswa', $idMahasiswa)
            ->select('op.id_kategori', 'op.kode', 'pp.poin')
            ->get();

        // Kelompokkan berdasarkan kategori
        $kategoriMap = [
            1 => 'jarak',
            2 => 'durasi_magang',
            3 => 'jenis_pelaksanaan',
            4 => 'jenis_perusahaan',
            5 => 'bidang_keahlian',
            6 => 'fasilitas',
        ];

        $result = [];

        foreach ($preferensi as $item) {
            $kategori = $kategoriMap[$item->id_kategori] ?? null;
            if ($kategori) {
                $result[$kategori][] = [
                    'kode' => $item->kode,
                    'poin' => $item->poin,
                ];
            }
        }

        return $result;
    }


    protected function getSkorJarak(array $preferensi, Lowongan $lowongan): int
    {
        $alamat = Str::lower($lowongan->perusahaan->alamat ?? '');

        $kategoriLokasi = match (true) {
            Str::contains($alamat, ['jawa timur', 'jatim']) &&
                Str::contains($alamat, ['malang', 'batu']) => 'dalam_kota',
            Str::contains($alamat, ['jawa timur', 'jatim']) => 'luar_kota',
            default => 'luar_provinsi'
        };

        foreach ($preferensi['jarak'] ?? [] as $pref) {
            if ($pref['kode'] === $kategoriLokasi) {
                return $pref['poin'];
            }
        }

        return 0;
    }

    protected function getSkorDurasi(array $preferensi, Lowongan $lowongan): int
    {
        $kode = $lowongan->durasiMagang->kode ?? '';

        foreach ($preferensi['durasi_magang'] ?? [] as $pref) {
            if ($pref['kode'] === $kode) {
                return $pref['poin'];
            }
        }

        return 0;
    }

    protected function getSkorPelaksanaan(array $preferensi, Lowongan $lowongan): int
    {
        $kode = $lowongan->jenisPelaksanaan->kode ?? '';

        return match (Str::lower($kode)) {
            'wfo' => 5,
            'hybrid' => 3,
            'wfh' => 1,
            default => 0, // Jika tidak dikenali
        };
    }


    protected function getSkorJenisPerusahaan(array $preferensi, Lowongan $lowongan): int
    {
        $jenisPerusahaan = Str::lower($lowongan->perusahaan->jenisPerusahaan ?? '');

        $opsiPerusahaan = OpsiPreferensi::where('id_kategori', 4)->get();

        $kategoriPerusahaan = $opsiPerusahaan->first(function ($opsi) use ($jenisPerusahaan) {
            return Str::contains($jenisPerusahaan, Str::lower($opsi->label));
        });

        if (!$kategoriPerusahaan) {
            return 0;
        }

        foreach ($preferensi['jenis_perusahaan'] ?? [] as $pref) {
            if ($pref['kode'] === $kategoriPerusahaan->kode) {
                return $pref['poin'];
            }
        }

        return 1;
    }

    protected function getSkorBidangKeahlian(array $preferensi, Lowongan $lowongan): int
    {
        $skor = 1;

        // Ambil semua kode bidang keahlian dari lowongan
        $kodeBidangLowongan = $lowongan->bidangKeahlian->pluck('kode')->toArray();

        // Loop preferensi pengguna
        foreach ($preferensi['bidang_keahlian'] ?? [] as $pref) {
            if (in_array($pref['kode'], $kodeBidangLowongan)) {
                $skor += $pref['poin'] ?? 0;
            }
        }

        return $skor;
    }

    protected function getSkorFasilitas(array $preferensi, Lowongan $lowongan): int
    {
        $fasilitasLowongan = $lowongan->fasilitas->pluck('kode')->toArray();
        $totalSkor = 1;

        foreach ($preferensi['fasilitas'] ?? [] as $fasilitas) {
            if (in_array($fasilitas['kode'], $fasilitasLowongan)) {
                $totalSkor += $fasilitas['poin'] ?? 0;
            }
        }

        return $totalSkor;
    }

    public function normalisasiMinMax($data)
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


    public function stddevSample($array)
    {
        $mean = array_sum($array) / count($array);
        $n = count($array);
        if ($n <= 1) return 0; // Hindari pembagian nol
        $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $array)) / ($n - 1);
        return sqrt($variance);
    }


    public function korelasiPearson($col1, $col2)
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

        if ($den1 == 0 || $den2 == 0) {
            // Varians nol: tidak bisa hitung korelasi
            return 0; // atau null, tergantung kebutuhan
        }
        return $num / sqrt($den1 * $den2);
    }

    public function bobotCRITIC($data)
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

    public function normalisasiBenefit($data)
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

    public function hitungWASPAS($data, $weights, $lambda = 0.5)
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
