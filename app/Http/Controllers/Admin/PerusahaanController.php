<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanMitra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = PerusahaanMitra::all();
        return view('admin.perusahaan.index', compact('perusahaan'));
    }

    public function list(Request $request)
    {
        $query = PerusahaanMitra::select('id_perusahaan', 'nama_perusahaan', 'bidang_industri', 'email', 'telepon');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($perusahaanMitra) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/perusahaan/' . $perusahaanMitra->id_perusahaan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/perusahaan/' . $perusahaanMitra->id_perusahaan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/perusahaan/' . $perusahaanMitra->id_perusahaan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.perusahaan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
            'alamat'          => 'required|string',
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email',
            'telepon'         => 'required|string|max:20',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'errors'   => $validator->errors(),
            ], 422);
        }

        PerusahaanMitra::create($request->only([
            'nama_perusahaan',
            'bidang_industri',
            'alamat',
            'email',
            'telepon'
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Data perusahaan berhasil disimpan',
        ]);
    }

    public function edit_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.perusahaan.edit_ajax', compact('perusahaan'));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
            'alamat'          => 'required|string',
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email,' . $id . ',id_perusahaan',
            'telepon'         => 'required|string|max:20',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'errors'    => $validator->errors(),
            ], 422);
        }

        $perusahaan = PerusahaanMitra::find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $perusahaan->update($request->only([
            'nama_perusahaan',
            'bidang_industri',
            'alamat',
            'email',
            'telepon'
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function show_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.perusahaan.show_ajax', compact('perusahaan'));
    }

    public function confirm_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.perusahaan.confirm_ajax', compact('perusahaan'));
    }

    public function delete_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $perusahaan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
