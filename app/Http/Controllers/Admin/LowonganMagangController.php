<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\PerusahaanMitra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LowonganMagangController extends Controller
{
    public function index()
    {
        $lowongan = Lowongan::with('perusahaan')->get();
        return view('admin.lowongan.index', compact('lowongan'));
    }

    public function list(Request $request)
    {
        $query = Lowongan::with('perusahaan')->select('lowongan.*');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($lowongan) {
                $btn  = '<button onclick="modalAction(\'' . url('lowongan/' . $lowongan->id_lowongan . '/show-ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('lowongan/' . $lowongan->id_lowongan . '/edit-ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('lowongan/' . $lowongan->id_lowongan . '/confirm-ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function create_ajax()
    {
        return view('admin.lowongan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'id_perusahaan'     => 'required|exists:perusahaan_mitra,id_perusahaan',
            'nama_posisi'       => 'required|string|max:100',
            'deskripsi'         => 'required|string',
            'kategori_keahlian' => 'required|string|max:100',
            'kuota'             => 'required|integer|min:1',
            'persyaratan'       => 'required|string',
            'tanggal_buka'      => 'required|date',
            'tanggal_tutup'     => 'required|date|after_or_equal:tanggal_buka',
            'durasi_magang'     => 'required|string|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        Lowongan::create($request->only(
            'id_perusahaan',
            'nama_posisi',
            'deskripsi',
            'kategori_keahlian',
            'kuota',
            'persyaratan',
            'tanggal_buka',
            'tanggal_tutup',
            'durasi_magang',
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Lowongan berhasil ditambahkan',
        ]);
    }

    public function edit_ajax($id)
    {
        $lowongan = Lowongan::find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $perusahaan = PerusahaanMitra::all();

        return view('admin.lowongan.edit_ajax', compact('lowongan', 'perusahaan'));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'id_perusahaan'     => 'required|exists:perusahaan_mitra,id_perusahaan',
            'nama_posisi'       => 'required|string|max:100',
            'deskripsi'         => 'required|string',
            'kategori_keahlian' => 'required|string|max:100',
            'kuota'             => 'required|integer|min:1',
            'persyaratan'       => 'required|string',
            'tanggal_buka'      => 'required|date',
            'tanggal_tutup'     => 'required|date|after_or_equal:tanggal_buka',
            'durasi_magang'     => 'required|string|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $lowongan = Lowongan::find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        $lowongan->update($request->only([
            'id_perusahaan',
            'nama_posisi',
            'deskripsi',
            'kategori_keahlian',
            'kuota',
            'persyaratan',
            'tanggal_buka',
            'tanggal_tutup',
            'durasi_magang',
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Lowongan berhasil diperbarui',
        ]);
    }

    public function show_ajax($id)
    {
        $lowongan = Lowongan::with('perusahaan')->find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.lowongan.show_ajax', compact('lowongan'));
    }

    public function confirm_ajax($id)
    {
        $lowongan = Lowongan::find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.lowongan.confirm_ajax', compact('lowongan'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $lowongan = Lowongan::find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $lowongan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
