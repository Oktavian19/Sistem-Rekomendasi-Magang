<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Services\RekomendasiService;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    protected $rekomendasiService;

    public function __construct(RekomendasiService $rekomendasiService)
    {
        $this->rekomendasiService = $rekomendasiService;
    }

    public function index()
    {
        $idMahasiswa = auth()->user()->mahasiswa->id_mahasiswa;

        // Ambil semua lowongan beserta perusahaan (id_lowongan, nama perusahaan, posisi)
        $lowongan = Lowongan::with('perusahaan')->get()->keyBy('id_lowongan');

        // Step 1: Matriks Alternatif (id_lowongan => [kriteria])
        $matriksAlternatif = $this->rekomendasiService->generateMatriksAlternatif($idMahasiswa);

        // Buat matriks alternatif dengan info nama perusahaan dan posisi
        $matriksAlternatifWithInfo = [];

        foreach ($matriksAlternatif as $idLowongan => $kriteria) {
            $namaPerusahaan = $lowongan[$idLowongan]->perusahaan->nama_perusahaan ?? '-';
            $namaPosisi = $lowongan[$idLowongan]->nama_posisi ?? '-';
            $matriksAlternatifWithInfo[$idLowongan] = [
                'perusahaan' => $namaPerusahaan,
                'posisi' => $namaPosisi,
                'kriteria' => $kriteria,
            ];
        }

        // Step 2: Normalisasi Min-Max tetap berdasarkan matriksAlternatif asli (tanpa info nama)
        $normalisasiMinMax = $this->rekomendasiService->normalisasiMinMax($matriksAlternatif);

        // Step 3: Hitung Bobot CRITIC
        $bobotCritic = $this->rekomendasiService->bobotCRITIC($matriksAlternatif);

        // Step 4: Normalisasi Benefit untuk WASPAS
        $normalisasiBenefit = $this->rekomendasiService->normalisasiBenefit($matriksAlternatif);

        // Step 5: Hitung WASPAS
        $hasilWaspas = $this->rekomendasiService->hitungWASPAS($matriksAlternatif, $bobotCritic);

        // Kirim semua step ke view
        return view('mahasiswa.rekomendasi.index', [
            'matriksAlternatif' => $matriksAlternatifWithInfo, // kirim data lengkap dengan nama
            'normalisasiMinMax' => $normalisasiMinMax,
            'bobotCritic' => $bobotCritic,
            'normalisasiBenefit' => $normalisasiBenefit,
            'hasilWaspas' => $hasilWaspas,
        ]);
    }
}
