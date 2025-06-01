<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\OpsiPreferensi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreferensiController extends Controller
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
                        $this->getSkorFasilitas($preferensi['fasilitas'] ?? [], $lowongan->fasilitas ?? [])
                    ]
                ];
            })
            ->all();
    }

    protected function getPreferensiMahasiswa(int $idMahasiswa): array
    {
        return OpsiPreferensi::where('id_mahasiswa', $idMahasiswa)
            ->get()
            ->groupBy('kategori')
            ->map(fn($items) => $items->pluck('skor', 'kode')->all())
            ->all();
    }

    protected function getSkorJarak(array $preferensi, Lowongan $lowongan): float
    {
        $alamat = Str::lower($lowongan->perusahaan->alamat ?? '');

        $kategoriLokasi = match (true) {
            Str::contains($alamat, ['jawa timur', 'jatim']) &&
                Str::contains($alamat, ['malang', 'batu']) => 'dalam_kota',
            Str::contains($alamat, ['jawa timur', 'jatim']) => 'luar_kota',
            default => 'luar_provinsi'
        };

        return $preferensi['jarak'][$kategoriLokasi] ?? 1.0;
    }

    protected function getSkorDurasi(array $preferensi, Lowongan $lowongan): float
    {
        return $preferensi['durasi'][$lowongan->durasi_magang] ?? 1.0;
    }

    protected function getSkorPelaksanaan(array $preferensi, Lowongan $lowongan): float
    {
        return $preferensi['pelaksanaan'][$lowongan->pelaksanaan] ?? 1.0;
    }

    protected function getSkorJenisPerusahaan(array $preferensi, Lowongan $lowongan): float
    {
        return $preferensi['jenis_perusahaan'][$lowongan->perusahaan->jenis] ?? 1.0;
    }

    protected function getSkorBidangKeahlian(array $preferensi, Lowongan $lowongan): float
    {
        return $preferensi['bidang_keahlian'][$lowongan->kategori_keahlian] ?? 1.0;
    }

    public function getSkorFasilitas(array $preferensiFasilitas, array $fasilitasLowongan): float
    {
        return collect($fasilitasLowongan)
            ->sum(fn($kode) => $preferensiFasilitas[$kode] ?? 0);
    }
}
