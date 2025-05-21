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
        $perusahaan = PerusahaanMitra::all();
        return view('admin.lowongan.index', compact('lowongan', 'perusahaan'));
    }

    public function list(Request $request)
    {
        $query = Lowongan::with(['perusahaan', 'bidangKeahlian'])->select('lowongan.*');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama_perusahaan', function ($row) {
                return $row->perusahaan->nama_perusahaan ?? '-';
            })
            ->addColumn('kategori_keahlian', function ($row) {
                return $row->bidangKeahlian->nama_bidang ?? '-';
            })
            ->addColumn('aksi', function ($lowongan) {
                $btn  = '<div class="dropdown">';
                $btn .= '<a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false">';
                $btn .= '<i class="bx bx-dots-vertical-rounded"></i>';
                $btn .= '</a>';
                $btn .= '<ul class="dropdown-menu">';

                // Detail link
                $btn .= '<li><a class="dropdown-item" href="' . url('lowongan/' . $lowongan->id_lowongan . '/show-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-show-alt"></i> Detail';
                $btn .= '</a></li>';

                // Edit link
                $btn .= '<li><a class="dropdown-item" href="' . url('lowongan/' . $lowongan->id_lowongan . '/edit-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-edit-alt"></i> Edit';
                $btn .= '</a></li>';

                // Delete link
                $btn .= '<li><a class="dropdown-item" href="' . url('lowongan/' . $lowongan->id_lowongan  . '/confirm-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-trash"></i> Hapus';
                $btn .= '</a></li>';

                $btn .= '</ul>';
                $btn .= '</div>';

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

        $perusahaans = PerusahaanMitra::all();

        return view('admin.lowongan.edit_ajax', compact('lowongan', 'perusahaans'));
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
        $lowongan = Lowongan::with('perusahaan', 'bidangKeahlian')->find($id);

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
