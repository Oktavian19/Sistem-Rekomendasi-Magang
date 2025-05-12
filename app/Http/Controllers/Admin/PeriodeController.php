<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeMagang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = PeriodeMagang::all();
        return view('admin.periode.index', compact('periode'));
    }

    public function list(Request $request)
    {
        $periode = PeriodeMagang::select('id_periode', 'nama_periode', 'tanggal_mulai', 'tanggal_selesai');

        if ($request->has('id_periode')) {
            $periode->where('id_periode', $request->id_periode);
        }

        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('aksi', function ($periode) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/periode/' . $periode->id_periode . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/periode/' . $periode->id_periode . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/periode/' . $periode->id_periode . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // === AJAX ===
    public function create_ajax()
    {
        return view('admin.periode.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'nama_periode'     => 'required|string|max:100',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        PeriodeMagang::create($request->only([
            'nama_periode',
            'tanggal_mulai',
            'tanggal_selesai',
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Periode berhasil disimpan',
        ]);
    }

    public function edit_ajax(string $id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        return view('admin.periode.edit_ajax', compact('periode'));
    }

    public function update_ajax(Request $request, string $id)
    {
        $rules = [
            'nama_periode'     => 'required|string|max:100',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $periode->update($request->only([
            'nama_periode',
            'tanggal_mulai',
            'tanggal_selesai',
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function show_ajax(string $id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.periode.show_ajax', compact('periode'));
    }

    public function confirm_ajax($id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.perusahaan.confirm_ajax', compact('perusahaan'));
    }

    public function delete_ajax($id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $periode->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
