<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\DosenPembimbing;

class DashboardController extends Controller
{
    public function dashboard_admin()
    {
        // 1. Jumlah Mahasiswa
        $jumlahMahasiswa = Mahasiswa::count();

        // 2. Statistik Status Magang
        $statusMagang = [
            'aktif'   => Magang::where('status_magang', 'aktif')->count(),
            'selesai' => Magang::where('status_magang', 'selesai')->count(),
            'belum'   => Magang::where('status_magang', 'belum')->count(),
        ];

        // 3. Jumlah Dosen Pembimbing
        $jumlahDosen = DosenPembimbing::count();

        // 4. Rasio Mahasiswa Magang Aktif : Dosen Pembimbing
        $jumlahMahasiswaMagangAktif = Magang::where('status_magang', 'aktif')->count();
        $rasioDosenMahasiswa = $jumlahDosen > 0
            ? round($jumlahMahasiswaMagangAktif / $jumlahDosen, 2)
            : 0;

        // 5. Statistik Tren Bidang Industri (Peminatan vs Realisasi)
        $realisasi = DB::table('magang')
            ->join('lamaran', 'magang.id_lamaran', '=', 'lamaran.id_lamaran')
            ->join('lowongan', 'lamaran.id_lowongan', '=', 'lowongan.id_lowongan')
            ->join('perusahaan_mitra', 'lowongan.id_perusahaan', '=', 'perusahaan_mitra.id_perusahaan')
            ->select('perusahaan_mitra.bidang_industri as nama_bidang', DB::raw('count(*) as total_magang'))
            ->groupBy('perusahaan_mitra.bidang_industri');

        $peminatan = DB::table('mahasiswa_bidang_keahlian')
            ->join('bidang_keahlian', 'mahasiswa_bidang_keahlian.id_bidang_keahlian', '=', 'bidang_keahlian.id_bidang_keahlian')
            ->select('bidang_keahlian.nama_bidang', DB::raw('count(*) as total_peminat'))
            ->groupBy('bidang_keahlian.nama_bidang');

        // Jadikan subquery:
        $peminatanSub = DB::table(DB::raw("({$peminatan->toSql()}) as peminatan"))
            ->mergeBindings($peminatan); // penting untuk bawa binding

        $trenBidangIndustri = $peminatanSub
            ->leftJoinSub($realisasi, 'realisasi', function ($join) {
                $join->on('peminatan.nama_bidang', '=', 'realisasi.nama_bidang');
            })
            ->select(
                'peminatan.nama_bidang',
                'total_peminat',
                DB::raw('COALESCE(total_magang, 0) as total_magang')
            )
            ->orderByDesc('total_peminat')
            ->get();


        // 6. Evaluasi Efektivitas Rekomendasi
        $mengikutiRekomendasi = DB::table('lamaran')
            ->where('dari_rekomendasi', true)
            ->count();

        $tidakMengikutiRekomendasi = DB::table('lamaran')
            ->where('dari_rekomendasi', false)
            ->count();

        return view('dashboard.admin', compact(
            'jumlahMahasiswa',
            'statusMagang',
            'jumlahDosen',
            'rasioDosenMahasiswa',
            'trenBidangIndustri',
            'mengikutiRekomendasi',
            'tidakMengikutiRekomendasi'
        ));
    }

    public function dashboard_dosen()
    {
        return view('dashboard.dosen');
    }

    public function dashboard_mahasiswa()
    {
        return view('dashboard.mahasiswa');
    }
}
