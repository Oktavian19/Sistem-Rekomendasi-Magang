<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\DosenPembimbing;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard_admin()
    {
        // 1. Jumlah Mahasiswa
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahLamaran = Lamaran::count();

        // 2. Statistik Status Magang
        $statusMagang = [
            'aktif'   => Magang::where('status_magang', 'aktif')->count(),
            'selesai' => Magang::where('status_magang', 'selesai')->count(),
            'belum'   => Magang::where('status_magang', 'belum')->count(),
        ];

        $statusLamaran = [
            'menunggu'   => Lamaran::where('status_lamaran', 'menunggu')->count(),
            'diterima' => Lamaran::where('status_lamaran', 'diterima')->count(),
            'ditolak'   => Lamaran::where('status_lamaran', 'ditolak')->count(),
        ];

        // 3. Jumlah Dosen Pembimbing
        $jumlahDosen = DosenPembimbing::count();

        // 4. Rasio Mahasiswa Magang Aktif : Dosen Pembimbing
        $jumlahMahasiswaMagangAktif = Magang::where('status_magang', 'aktif')->count();
        $rasioDosenMahasiswa = $jumlahDosen > 0
            ? round($jumlahMahasiswaMagangAktif / $jumlahDosen, 2)
            : 0;

        // 5. Statistik Tren Bidang Industri (Peminatan vs Realisasi)
        $peminatan = DB::table('mahasiswa_bidang_keahlian')
            ->join('bidang_keahlian', 'mahasiswa_bidang_keahlian.id_bidang_keahlian', '=', 'bidang_keahlian.id_bidang_keahlian')
            ->select('bidang_keahlian.nama_bidang', DB::raw('count(*) as total_peminat'))
            ->groupBy('bidang_keahlian.nama_bidang');

        $realisasi = DB::table('magang')
            ->join('lamaran', 'magang.id_lamaran', '=', 'lamaran.id_lamaran')
            ->join('lowongan', 'lamaran.id_lowongan', '=', 'lowongan.id_lowongan')
            ->join('bidang_keahlian', 'lowongan.id_bidang_keahlian', '=', 'bidang_keahlian.id_bidang_keahlian')
            ->select('bidang_keahlian.nama_bidang', DB::raw('count(*) as total_magang'))
            ->groupBy('bidang_keahlian.nama_bidang');


        $trenBidangIndustri = DB::table(DB::raw("({$peminatan->toSql()}) as peminatan"))
            ->mergeBindings($peminatan)
            ->leftJoinSub($realisasi, 'realisasi', function ($join) {
                $join->on('peminatan.nama_bidang', '=', 'realisasi.nama_bidang');
            })
            ->select(
                'peminatan.nama_bidang',
                'peminatan.total_peminat',
                DB::raw('COALESCE(realisasi.total_magang, 0) as total_magang')
            )
            ->get();

        // 6. Evaluasi Efektivitas Rekomendasi
        $mengikutiRekomendasi = DB::table('lamaran')
            ->where('dari_rekomendasi', true)
            ->count();

        $persentaseMengikutiRekomendasi = $mengikutiRekomendasi/$jumlahLamaran*100;

        return view('dashboard.admin', compact(
            'jumlahMahasiswa',
            'statusMagang',
            'statusLamaran',
            'jumlahDosen',
            'rasioDosenMahasiswa',
            'trenBidangIndustri',
            'persentaseMengikutiRekomendasi',
        ));
    }

    public function dashboard_dosen()
    {
        return view('dashboard.dosen');
    }

    public function dashboard_mahasiswa()
    {
        $user = Auth::user();

        $dataMahasiswa = Mahasiswa::where('id_mahasiswa', $user->mahasiswa->id_mahasiswa)->first();

        if (!$dataMahasiswa || empty($dataMahasiswa->preferensi_lokasi) || empty($dataMahasiswa->id_program_studi)) {
            return view('dashboard.mahasiswa_kosong');
        }

        return view('dashboard.mahasiswa', compact('dataMahasiswa'));
    }

}
