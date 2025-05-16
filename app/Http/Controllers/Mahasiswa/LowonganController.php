<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\PerusahaanMitra;
use Yajra\DataTables\Facades\DataTables;

class LowonganController extends Controller
{
    public function index()
    {
        return view('mahasiswa.magang.lowongan');
    }

    public function list(Request $request)
    {
        $lowongan = Lowongan::select([
                'lowongan.id_lowongan',
                'lowongan.nama_posisi',
                'lowongan.kategori_keahlian',
                'lowongan.kuota',
                'lowongan.tanggal_buka',
                'lowongan.tanggal_tutup',
                'lowongan.durasi_magang',
                'perusahaan_mitra.nama_perusahaan'
            ])
            ->leftJoin('perusahaan_mitra', 'lowongan.id_perusahaan', '=', 'perusahaan_mitra.id_perusahaan');

        return DataTables::of($lowongan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn  = '<button onclick="modalAction(\'' . url('lowongan/' . $row->id_lowongan . '/show-ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('lowongan/' . $row->id_lowongan . '/edit-ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('lowongan/' . $row->id_lowongan . '/delete-ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

}
