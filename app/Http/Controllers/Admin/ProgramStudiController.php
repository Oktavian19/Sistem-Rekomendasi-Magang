<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $programStudi = ProgramStudi::all();
        return view('admin.program_studi.index', compact('programStudi'));
    }

    public function list(Request $request)
    {
        $programStudi = ProgramStudi::select('id_program_studi', 'nama_program_studi');

        if ($request->has('id_program_studi')) {
            $programStudi->where('id_program_studi', $request->id_program_studi);
        }

        return DataTables::of($programStudi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($programStudi) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/program_studi/' . $programStudi->id_program_studi . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/program_studi/' . $programStudi->id_program_studi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/program_studi/' . $programStudi->id_program_studi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.program_studi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_program_studi' => 'required|string|max:100|unique:program_studi,nama_program_studi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        ProgramStudi::create($request->only('nama_program_studi'));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
        ]);
    }

    public function edit_ajax($id)
    {
        $programStudi = ProgramStudi::find($id);

        if (!$programStudi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.program_studi.edit_ajax', compact('programStudi'));
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_program_studi' => 'required|string|max:100|unique:program_studi,nama_program_studi,' . $id . ',id_program_studi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $programStudi = ProgramStudi::find($id);

        if (!$programStudi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $programStudi->update($request->only('nama_program_studi'));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function show_ajax($id)
    {
        $programStudi = ProgramStudi::find($id);

        if (!$programStudi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.program_studi.show_ajax', compact('programStudi'));
    }

    public function confirm_ajax($id)
    {
        $programStudi = ProgramStudi::find($id);

        if (!$programStudi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.program_studi.confirm_ajax', compact('programStudi'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $programStudi = ProgramStudi::find($id);

        if (!$programStudi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $programStudi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
