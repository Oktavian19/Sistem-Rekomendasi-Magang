<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\DosenPembimbing;
use App\Models\Lamaran;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use App\Services\RekomendasiService;

class DashboardController extends Controller
{
    protected $rekomendasiService;

    public function __construct(RekomendasiService $rekomendasiService)
    {
        $this->rekomendasiService = $rekomendasiService;
    }

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
            'menunggu'  => Lamaran::whereIn('status_lamaran', ['diprosesAdmin', 'diprosesPerusahaan'])->count(),
            'diterima'  => Lamaran::where('status_lamaran', 'diterima')->count(),
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
        $peminatan = DB::table('preferensi_pengguna')
            ->join('opsi_preferensi', 'preferensi_pengguna.id_opsi', '=', 'opsi_preferensi.id')
            ->join('kategori_preferensi', 'opsi_preferensi.id_kategori', '=', 'kategori_preferensi.id')
            ->select('opsi_preferensi.label', DB::raw('count(*) as total_peminat'))
            ->where('kategori_preferensi.kode', 'bidang_keahlian')
            ->groupBy('opsi_preferensi.label');

        $realisasi = DB::table('magang')
            ->join('lamaran', 'magang.id_lamaran', '=', 'lamaran.id_lamaran')
            ->join('lowongan', 'lamaran.id_lowongan', '=', 'lowongan.id_lowongan')
            ->join('preferensi_lowongan', 'lowongan.id_lowongan', '=', 'preferensi_lowongan.id_lowongan')
            ->join('opsi_preferensi', 'preferensi_lowongan.id_opsi', '=', 'opsi_preferensi.id')
            ->join('kategori_preferensi', 'opsi_preferensi.id_kategori', '=', 'kategori_preferensi.id')
            ->where('kategori_preferensi.kode', 'bidang_keahlian')
            ->select('opsi_preferensi.label', DB::raw('count(*) as total_magang'))
            ->groupBy('opsi_preferensi.label');

        $trenBidangIndustri = DB::table(DB::raw("({$peminatan->toSql()}) as peminatan"))
            ->mergeBindings($peminatan)
            ->leftJoinSub($realisasi, 'realisasi', function ($join) {
                $join->on('peminatan.label', '=', 'realisasi.label');
            })
            ->select(
                'peminatan.label',
                'peminatan.total_peminat',
                DB::raw('COALESCE(realisasi.total_magang, 0) as total_magang')
            )
            ->get();


        // 6. Evaluasi Efektivitas Rekomendasi
        $mengikutiRekomendasi = DB::table('lamaran')
            ->where('dari_rekomendasi', true)
            ->count();

        $persentaseMengikutiRekomendasi = $mengikutiRekomendasi / $jumlahLamaran * 100;

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

        $preferensiPenggunaData = DB::table('preferensi_pengguna as pp')
            ->join('opsi_preferensi as op', 'pp.id_opsi', '=', 'op.id') // SESUAI: pp.id_opsi menunjuk ke op.id
            ->join('kategori_preferensi as kp', 'op.id_kategori', '=', 'kp.id') // SESUAI: op.id_kategori menunjuk ke kp.id
            ->select(
                'pp.id_mahasiswa',
                'pp.id_opsi',
                'pp.ranking',
                'pp.poin',
                'op.label as nama_opsi',
                'op.kode as kode_opsi',
                'kp.kode as kode_kategori',
                'kp.nama as nama_kategori'
            )
            ->where('pp.id_mahasiswa', $dataMahasiswa->id_mahasiswa)
            ->get();

        // Inisialisasi variabel untuk menyimpan preferensi berdasarkan kategori
        $jarak = collect();
        $jenisPerusahaan = collect();
        $bidangKeahlian = collect();
        $fasilitas = collect();

        // Loop melalui hasil dan kelompokkan berdasarkan kode kategori
        foreach ($preferensiPenggunaData as $pref) {
            switch ($pref->kode_kategori) {
                case 'jarak':
                    $jarak->push($pref);
                    break;
                case 'jenis_perusahaan':
                    $jenisPerusahaan->push($pref);
                    break;
                case 'bidang_keahlian':
                    $bidangKeahlian->push($pref);
                    break;
                case 'fasilitas':
                    $fasilitas->push($pref);
                    break;
            }
        }

        if (!$dataMahasiswa || empty($dataMahasiswa->id_program_studi) || $jarak->isEmpty() || $jenisPerusahaan->isEmpty() || $bidangKeahlian->isEmpty() || $fasilitas->isEmpty()) {
            return view('dashboard.mahasiswa_kosong');
        }

        $progressBarStatus = null;

        // 1. Cek apakah ada lamaran untuk mahasiswa ini
        $lamaran = Lamaran::where('id_mahasiswa', $dataMahasiswa->id_mahasiswa)
            ->latest('tanggal_lamaran') // Ambil lamaran terbaru jika ada banyak
            ->first();

        if ($lamaran) {
            // Jika ada lamaran, langkah 1 (Lamaran Dikirim) dan 2 (Diproses Admin) aktif
            $progressBarStatus['step1_active'] = true;
            $progressBarStatus['step2_active'] = true;

            // 2. Cek status lamaran
            if ($lamaran->status_lamaran === 'diterima') {
                // Jika lamaran diterima, langkah 3 (Lamaran Disetujui) dan 4 (Magang Berlangsung) aktif
                $progressBarStatus['step3_active'] = true;
                $progressBarStatus['step4_active'] = true;
                $progressBarStatus['step3_icon'] = 'fa-check'; // Pastikan icon tetap check

                // 3. Cek tabel Magang jika lamaran diterima
                $magang = $lamaran->magang; // Gunakan relasi hasOne untuk mengambil data magang terkait

                if ($magang && $magang->status_magang === 'selesai') {
                    // Jika magang selesai, langkah 5 (Magang Selesai) aktif
                    $progressBarStatus['step5_active'] = true;
                }
            } elseif ($lamaran->status_lamaran === 'ditolak') {
                // Jika lamaran ditolak, beri tanda silang pada langkah 3
                $progressBarStatus['step3_active'] = true; // Atau false, tergantung apakah kamu mau kotaknya tetap aktif tapi isinya silang
                $progressBarStatus['step3_icon'] = 'fa-xmark'; // Ganti icon menjadi silang
            }
            // Jika status_lamaran 'menunggu', maka hanya langkah 1 & 2 yang aktif (sudah diatur di atas)
        }

        $detailLamaranTerakhir = null; // Inisialisasi variabel untuk detail lamaran

        // Ambil lamaran terbaru untuk mahasiswa, dengan eager loading lowongan dan perusahaan mitra
        $latestLamaran = Lamaran::with(['lowongan.perusahaan'])
            ->where('id_mahasiswa', $dataMahasiswa->id_mahasiswa)
            ->latest('tanggal_lamaran')
            ->first();

        if ($latestLamaran) {
            // Jika ada lamaran
            $perusahaan = $latestLamaran->lowongan->perusahaan ?? null; // Null coalescing jika relasi tidak ada
            $lowongan = $latestLamaran->lowongan ?? null;

            $detailLamaranTerakhir = [
                'nama_perusahaan' => $perusahaan->nama_perusahaan ?? 'N/A',
                'bidang_industri' => $perusahaan->bidang_industri ?? 'N/A',
                'posisi_magang' => $lowongan->nama_posisi ?? 'N/A', // Asumsi kolom posisi_magang ada di tabel lowongan
                'tanggal_dikirim' => \Carbon\Carbon::parse($latestLamaran->tanggal_lamaran)->isoFormat('D MMMM YYYY'), // Format tanggal
            ];
        }

        $alternatif = $this->rekomendasiService->generateMatriksAlternatif($dataMahasiswa->id_mahasiswa);
        $bobot = $this->rekomendasiService->bobotCRITIC($alternatif);
        $hasil = $this->rekomendasiService->hitungWASPAS($alternatif, $bobot);


        $lowonganIds = array_keys(array_slice($hasil, 0, 6, true));

        // Ambil data lowongan yang termasuk dalam hasil
        $rekomendasi = Lowongan::with(['perusahaan', 'jenisPelaksanaan'])
            ->whereIn('id_lowongan', $lowonganIds)
            ->get()
            ->keyBy('id_lowongan');

        // Susun kembali sesuai urutan skor
        $rekomendasiTerurut = collect($lowonganIds)->map(function ($id) use ($rekomendasi, $hasil) {
            $lowongan = $rekomendasi[$id];
            $lowongan->skor = $hasil[$id]; // Tambahkan skor WASPAS ke objek
            return $lowongan;
        });


        return view('dashboard.mahasiswa', compact('dataMahasiswa', 'progressBarStatus', 'detailLamaranTerakhir', 'rekomendasiTerurut'));
    }
}
