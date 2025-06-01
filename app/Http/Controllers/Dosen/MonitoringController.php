<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('dosen.monitoring.list_mahasiswa');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $idDosenPembimbing = Auth::user()->id_user; // diasumsikan ini adalah id_dosen_pembimbing

            $data = Mahasiswa::whereHas('lamaran.magang', function ($query) use ($idDosenPembimbing) {
                $query->where('id_dosen_pembimbing', $idDosenPembimbing);
            })->select(['id_mahasiswa', 'nama', 'nim', 'email', 'no_hp']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('email', function ($row) {
                    return $row->email ?? '-';
                })
                ->editColumn('no_hp', function ($row) {
                    return $row->no_hp ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '
                        <button class="btn btn-sm btn-outline-info me-2 btn-detail" data-id="' . $row->id_mahasiswa . '"><i class="bi bi-info-circle me-1"></i>Lihat Detail</button>

                        <a href="' . url('/mahasiswa/' . $row->id_mahasiswa . '/logs') . '" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-journal-text me-1"></i> Lihat Log
                        </a>
                    ';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::with([
            'lamaran.magang',
            'lamaran.lowongan.perusahaan',
            'lamaran.lowongan.bidangKeahlian'
        ])->findOrFail($id);

        $lamaranAktif = $mahasiswa->lamaran->firstWhere('magang.id_dosen_pembimbing', Auth::user()->id_user);

        if (!$lamaranAktif || !$lamaranAktif->magang) {
            return response()->json(['message' => 'Detail magang tidak ditemukan.'], 404);
        }

        $magang = $lamaranAktif->magang;
        $lowongan = $lamaranAktif->lowongan;

        return view('dosen.monitoring.detail', [
            'posisi' => $lowongan->nama_posisi,
            'perusahaan' => $lowongan->perusahaan->nama_perusahaan,
            'bidang' => $lowongan->bidangKeahlian->nama_bidang ?? '-',
            'durasi' => $lowongan->durasi_magang,
            'alamat' => $lowongan->perusahaan->alamat ?? '-',
        ]);
    }
}
