<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\OpsiPreferensi;
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
        $totalLowongan = $lowongan->count();
        $totalKuota = $lowongan->sum('kuota');
        return view('admin.lowongan.index', compact('lowongan', 'perusahaan', 'totalLowongan', 'totalKuota'));
    }

    public function list(Request $request)
    {
        $query = Lowongan::with(['perusahaan', 'jenisPelaksanaan', 'durasiMagang'])->select('lowongan.*');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        if ($request->filled('nama_posisi')) {
            $query->where('nama_posisi', $request->nama_posisi);
        }

        if ($request->filled('jenis_pelaksanaan')) {
            $query->whereHas('jenisPelaksanaan', function ($q) use ($request) {
                $q->where('label', 'like', '%' . $request->jenis_pelaksanaan . '%');
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama_perusahaan', function ($row) {
                return $row->perusahaan->nama_perusahaan ?? '-';
            })
            ->addColumn('jenis_pelaksanaan', function ($row) {
                return $row->jenisPelaksanaan->label ?? '-';
            })
            ->addColumn('durasi_magang', function ($row) {
                return $row->durasiMagang->label ?? '-';
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
        $perusahaans = PerusahaanMitra::all();

        $bidangKeahlians = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'bidang_keahlian');
        })->get();

        $jenisPelaksanaans = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'jenis_pelaksanaan');
        })->get();

        $durasiMagangs = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'durasi_magang');
        })->get();

        $fasilitas = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'fasilitas');
        })->get();

        return view('admin.lowongan.create_ajax', compact(
            'perusahaans',
            'bidangKeahlians',
            'jenisPelaksanaans',
            'durasiMagangs',
            'fasilitas'
        ));
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'id_perusahaan'         => 'required|exists:perusahaan_mitra,id_perusahaan',
            'nama_posisi'           => 'required|string|max:100',
            'deskripsi'             => 'required|string',
            'id_bidang_keahlian'    => 'required|array|min:1',
            'id_bidang_keahlian.*'  => 'exists:opsi_preferensi,id',
            'id_fasilitas'          => 'nullable|array',
            'id_fasilitas.*'        => 'exists:opsi_preferensi,id',
            'id_jenis_pelaksanaan'  => 'required|exists:opsi_preferensi,id',
            'kuota'                 => 'required|integer|min:1',
            'persyaratan'           => 'required|string',
            'tanggal_buka'          => 'required|date',
            'tanggal_tutup'         => 'required|date|after_or_equal:tanggal_buka',
            'id_durasi_magang'      => 'required|exists:opsi_preferensi,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $lowongan = Lowongan::create([
            'id_perusahaan' => $request->id_perusahaan,
            'nama_posisi' => $request->nama_posisi,
            'deskripsi' => $request->deskripsi,
            'id_jenis_pelaksanaan' => $request->id_jenis_pelaksanaan,
            'id_durasi_magang' => $request->id_durasi_magang,
            'kuota' => $request->kuota,
            'persyaratan' => $request->persyaratan,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
        ]);

        if ($request->has('id_bidang_keahlian')) {
            $lowongan->bidangKeahlian()->attach($request->id_bidang_keahlian);
        }

        if ($request->has('id_fasilitas')) {
            $lowongan->fasilitas()->attach($request->id_fasilitas);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Lowongan berhasil ditambahkan',
        ]);
    }


    public function edit_ajax($id)
    {
        $lowongan = Lowongan::with([
            'perusahaan',
            'bidangKeahlian',
            'fasilitas',
            'jenisPelaksanaan',
            'durasiMagang'
        ])->find($id);

        if (!$lowongan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $perusahaans = PerusahaanMitra::all();

        $bidangKeahlians = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'bidang_keahlian');
        })->get();

        $jenisPelaksanaans = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'jenis_pelaksanaan');
        })->get();

        $durasiMagangs = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'durasi_magang');
        })->get();

        $fasilitas = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'fasilitas');
        })->get();

        return view('admin.lowongan.edit_ajax', compact(
            'lowongan',
            'perusahaans',
            'bidangKeahlians',
            'jenisPelaksanaans',
            'durasiMagangs',
            'fasilitas'
        ));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'id_perusahaan'         => 'required|exists:perusahaan_mitra,id_perusahaan',
            'nama_posisi'           => 'required|string|max:100',
            'deskripsi'             => 'required|string',
            'id_bidang_keahlian'    => 'required|array|min:1',
            'id_bidang_keahlian.*'  => 'exists:opsi_preferensi,id',
            'id_fasilitas'          => 'nullable|array',
            'id_fasilitas.*'        => 'exists:opsi_preferensi,id',
            'id_jenis_pelaksanaan'  => 'required|exists:opsi_preferensi,id',
            'kuota'                 => 'required|integer|min:1',
            'persyaratan'           => 'required|string',
            'tanggal_buka'          => 'required|date',
            'tanggal_tutup'         => 'required|date|after_or_equal:tanggal_buka',
            'id_durasi_magang'      => 'required|exists:opsi_preferensi,id',
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

        // Update data utama
        $lowongan->update([
            'id_perusahaan'        => $request->id_perusahaan,
            'nama_posisi'          => $request->nama_posisi,
            'deskripsi'            => $request->deskripsi,
            'id_jenis_pelaksanaan' => $request->id_jenis_pelaksanaan,
            'kuota'                => $request->kuota,
            'persyaratan'          => $request->persyaratan,
            'tanggal_buka'         => $request->tanggal_buka,
            'tanggal_tutup'        => $request->tanggal_tutup,
            'id_durasi_magang'     => $request->id_durasi_magang,
        ]);

        $bidangIDs = array_map('intval', $request->id_bidang_keahlian ?? []);
        $fasilitasIDs = array_map('intval', $request->id_fasilitas ?? []);

        $lowongan->semuaPreferensi()->sync(array_merge($bidangIDs, $fasilitasIDs));

        return response()->json([
            'status'  => true,
            'message' => 'Lowongan berhasil diperbarui',
        ]);
    }


    public function show_ajax($id)
    {
        $lowongan = Lowongan::with([
            'perusahaan',
            'bidangKeahlian',
            'fasilitas',
            'jenisPelaksanaan',
            'durasiMagang'
        ])->find($id);

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
