<?php

namespace App\Http\Controllers;

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

        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('aksi', function ($item) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/periode/' . $item->id_periode . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/periode/' . $item->id_periode . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/periode/' . $item->id_periode . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode'     => 'required|string|max:100',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        PeriodeMagang::create($request->all());

        return redirect('/admin/periode')->with('success', 'Periode berhasil ditambahkan');
    }

    public function show(PeriodeMagang $periode)
    {
        return view('admin.periode.show', compact('periode'));
    }

    public function edit(PeriodeMagang $periode)
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodeMagang $periode)
    {
        $request->validate([
            'nama_periode'     => 'required|string|max:100',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $periode->update($request->all());

        return redirect('/admin/periode')->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy(PeriodeMagang $periode)
    {
        try {
            $periode->delete();
            return redirect('/admin/periode')->with('success', 'Periode berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admin/periode')->with('error', 'Gagal menghapus karena data terkait');
        }
    }

    // === AJAX ===
    public function create_ajax()
    {
        return view('admin.periode.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'nama_periode'     => 'required|string|max:100',
                'tanggal_mulai'    => 'required|date',
                'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            PeriodeMagang::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Periode berhasil disimpan',
            ]);
        }

        return redirect('/admin/periode');
    }

    public function edit_ajax(string $id)
    {
        $periode = PeriodeMagang::find($id);
        return view('admin.periode.edit_ajax', compact('periode'));
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'nama_periode'     => 'required|string|max:100',
                'tanggal_mulai'    => 'required|date',
                'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $periode = PeriodeMagang::find($id);

            if ($periode) {
                $periode->update($request->all());
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

        return redirect('/admin/periode');
    }

    public function show_ajax(string $id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return view('admin.periode.show_ajax', compact('periode'));
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax()) {
            $periode = PeriodeMagang::find($id);

            if ($periode) {
                $periode->delete();
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

        return redirect('/admin/periode');
    }
}
