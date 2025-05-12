<?php

namespace App\Http\Controllers;

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

        return DataTables::of($programStudi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($prodi) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/program-studi/' . $prodi->id_program_studi . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/program-studi/' . $prodi->id_program_studi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/program-studi/' . $prodi->id_program_studi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.program_studi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program_studi' => 'required|string|max:100|unique:program_studi,nama_program_studi',
        ]);

        ProgramStudi::create($request->only('nama_program_studi'));

        return redirect('/admin/program-studi')->with('success', 'Data program studi berhasil disimpan');
    }

    public function show(ProgramStudi $program_studi)
    {
        return view('admin.program_studi.show', ['programStudi' => $program_studi]);
    }

    public function edit(ProgramStudi $program_studi)
    {
        return view('admin.program_studi.edit', ['programStudi' => $program_studi]);
    }

    public function update(Request $request, ProgramStudi $program_studi)
    {
        $request->validate([
            'nama_program_studi' => 'required|string|max:100|unique:program_studi,nama_program_studi,' . $program_studi->id_program_studi . ',id_program_studi',
        ]);

        $program_studi->update($request->only('nama_program_studi'));

        return redirect('/admin/program-studi')->with('success', 'Data program studi berhasil diubah');
    }

    public function destroy(ProgramStudi $program_studi)
    {
        try {
            $program_studi->delete();
            return redirect('/admin/program-studi')->with('success', 'Data program studi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admin/program-studi')->with('error', 'Gagal menghapus data program studi');
        }
    }

    public function create_ajax()
    {
        return view('admin.program_studi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'nama_program_studi' => 'required|string|max:100|unique:program_studi,nama_program_studi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            ProgramStudi::create($request->only('nama_program_studi'));

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        }

        return redirect('/admin/program-studi');
    }

    public function edit_ajax($id)
    {
        $programStudi = ProgramStudi::find($id);
        return view('admin.program_studi.edit_ajax', compact('programStudi'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'nama_program_studi' => 'required|string|max:100|unique:program_studi,nama_program_studi,' . $id . ',id_program_studi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $programStudi = ProgramStudi::find($id);
            if ($programStudi) {
                $programStudi->update($request->only('nama_program_studi'));

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/program-studi');
    }

    public function show_ajax($id)
    {
        $programStudi = ProgramStudi::find($id);
        if (!$programStudi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return view('admin.program_studi.show_ajax', compact('programStudi'));
    }

    public function confirm_ajax($id)
    {
        $programStudi = ProgramStudi::find($id);
        return view('admin.program_studi.confirm_ajax', compact('programStudi'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $programStudi = ProgramStudi::find($id);

            if ($programStudi) {
                $programStudi->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/program-studi');
    }
}
