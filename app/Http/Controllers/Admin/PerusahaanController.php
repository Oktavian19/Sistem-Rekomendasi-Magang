<?php

namespace App\Http\Controllers;

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

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($perusahaan) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/perusahaan/' . $perusahaan->id_perusahaan . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/perusahaan/' . $perusahaan->id_perusahaan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/perusahaan/' . $perusahaan->id_perusahaan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.perusahaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
            'alamat'          => 'required|string',
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email',
            'telepon'         => 'required|string|max:20',
        ]);

        PerusahaanMitra::create($request->all());

        return redirect('/admin/perusahaan')->with('success', 'Data perusahaan berhasil disimpan');
    }

    public function show(PerusahaanMitra $perusahaan)
    {
        return view('admin.perusahaan.show', compact('perusahaan'));
    }

    public function edit(PerusahaanMitra $perusahaan)
    {
        return view('admin.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, PerusahaanMitra $perusahaan)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
            'alamat'          => 'required|string',
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email,' . $perusahaan->id_perusahaan . ',id_perusahaan',
            'telepon'         => 'required|string|max:20',
        ]);

        $perusahaan->update($request->all());

        return redirect('/admin/perusahaan')->with('success', 'Data perusahaan berhasil diperbarui');
    }

    public function destroy(PerusahaanMitra $perusahaan)
    {
        try {
            $perusahaan->delete();
            return redirect('/admin/perusahaan')->with('success', 'Data perusahaan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/admin/perusahaan')->with('error', 'Data gagal dihapus karena ada keterkaitan dengan data lain');
        }
    }

    // AJAX section

    public function create_ajax()
    {
        return view('admin.perusahaan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                    'msgField' => $validator->errors(),
                ]);
            }

            PerusahaanMitra::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Data perusahaan berhasil disimpan',
            ]);
        }

        return redirect('/admin/perusahaan');
    }

    public function edit_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);
        return view('admin.perusahaan.edit_ajax', compact('perusahaan'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                    'msgField' => $validator->errors(),
                ]);
            }

            $perusahaan = PerusahaanMitra::find($id);
            if ($perusahaan) {
                $perusahaan->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/perusahaan');
    }

    public function show_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return view('admin.perusahaan.show_ajax', compact('perusahaan'));
    }

    public function confirm_ajax($id)
    {
        $perusahaan = PerusahaanMitra::find($id);
        return view('admin.perusahaan.confirm_ajax', compact('perusahaan'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $perusahaan = PerusahaanMitra::find($id);

            if ($perusahaan) {
                $perusahaan->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/perusahaan');
    }
}
