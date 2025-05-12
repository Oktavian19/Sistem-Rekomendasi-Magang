<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\PerusahaanMitra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongan = Lowongan::with('perusahaan')->get();
        return view('admin.lowongan.index', compact('lowongan'));
    }

    public function list(Request $request)
    {
        $query = Lowongan::with('perusahaan')->select('lowongan.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('perusahaan', fn($row) => $row->perusahaan->nama_perusahaan ?? '-')
            ->addColumn('aksi', function ($row) {
                return view('admin.lowongan.partials.aksi', compact('row'))->render();
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $perusahaan = PerusahaanMitra::all();
        return view('admin.lowongan.create', compact('perusahaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_perusahaan'     => 'required|exists:perusahaan_mitra,id_perusahaan',
            'nama_posisi'       => 'required|string|max:100',
            'deskripsi'         => 'required|string',
            'kategori_keahlian' => 'required|string|max:100',
            'kuota'             => 'required|integer|min:1',
            'persyaratan'       => 'required|string',
            'tanggal_buka'      => 'required|date',
            'tanggal_tutup'     => 'required|date|after_or_equal:tanggal_buka',
            'durasi_magang'     => 'required|string|max:50',
        ]);

        Lowongan::create($request->all());

        return redirect('/admin/lowongan')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function show($id)
    {
        $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
        return view('admin.lowongan.show', compact('lowongan'));
    }

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $perusahaan = PerusahaanMitra::all();
        return view('admin.lowongan.edit', compact('lowongan', 'perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $request->validate([
            'id_perusahaan'     => 'required|exists:perusahaan_mitra,id_perusahaan',
            'nama_posisi'       => 'required|string|max:100',
            'deskripsi'         => 'required|string',
            'kategori_keahlian' => 'required|string|max:100',
            'kuota'             => 'required|integer|min:1',
            'persyaratan'       => 'required|string',
            'tanggal_buka'      => 'required|date',
            'tanggal_tutup'     => 'required|date|after_or_equal:tanggal_buka',
            'durasi_magang'     => 'required|string|max:50',
        ]);

        $lowongan->update($request->all());

        return redirect('/admin/lowongan')->with('success', 'Lowongan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $lowongan = Lowongan::find($id);
        if (!$lowongan) {
            return redirect('/admin/lowongan')->with('error', 'Data tidak ditemukan');
        }

        try {
            $lowongan->delete();
            return redirect('/admin/lowongan')->with('success', 'Lowongan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admin/lowongan')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function create_ajax()
    {
        $perusahaan = PerusahaanMitra::all();
        return view('admin.lowongan.create_ajax', compact('perusahaan'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                ]);
            }

            Lowongan::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Lowongan berhasil ditambahkan',
            ]);
        }

        return redirect('/admin/lowongan');
    }

    public function edit_ajax($id)
    {
        $lowongan = Lowongan::find($id);
        $perusahaan = PerusahaanMitra::all();

        return view('admin.lowongan.edit_ajax', compact('lowongan', 'perusahaan'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                ]);
            }

            $lowongan = Lowongan::find($id);
            if ($lowongan) {
                $lowongan->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Lowongan berhasil diperbarui',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/lowongan');
    }

    public function show_ajax($id)
    {
        $lowongan = Lowongan::with('perusahaan')->find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return view('admin.lowongan.show_ajax', compact('lowongan'));
    }

    public function confirm_ajax($id)
    {
        $lowongan = Lowongan::find($id);
        return view('admin.lowongan.confirm_ajax', compact('lowongan'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $lowongan = Lowongan::find($id);

            if ($lowongan) {
                $lowongan->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Lowongan berhasil dihapus',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/lowongan');
    }
}
