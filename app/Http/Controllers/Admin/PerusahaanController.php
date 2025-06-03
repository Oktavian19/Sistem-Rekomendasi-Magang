<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanMitra;
use App\Models\OpsiPreferensi; // Add this for company types
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = PerusahaanMitra::all();
        $totalPerusahaan = PerusahaanMitra::count();
        $totalBidangIndustri = PerusahaanMitra::distinct('bidang_industri')->count('bidang_industri');
        return view('admin.perusahaan.index', compact('perusahaan', 'totalPerusahaan', 'totalBidangIndustri'));
    }

    public function list(Request $request)
    {
        $query = PerusahaanMitra::select('id_perusahaan', 'nama_perusahaan', 'bidang_industri', 'email', 'telepon', 'alamat', 'path_logo');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        if ($request->filled('bidang_industri')) {
            $query->where('bidang_industri', $request->bidang_industri);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('jenis_perusahaan', function ($perusahaan) {
                return $perusahaan->jenisPerusahaan ? $perusahaan->jenisPerusahaan->label : '-';
            })
            ->addColumn('aksi', function ($perusahaanMitra) {
                $btn  = '<div class="dropdown">';
                $btn .= '<a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false">';
                $btn .= '<i class="bx bx-dots-vertical-rounded"></i>';
                $btn .= '</a>';
                $btn .= '<ul class="dropdown-menu">';

                // Detail link
                $btn .= '<li><a class="dropdown-item" href="' . url('perusahaan/' . $perusahaanMitra->id_perusahaan . '/show-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-show-alt"></i> Detail';
                $btn .= '</a></li>';

                // Edit link
                $btn .= '<li><a class="dropdown-item" href="' . url('perusahaan/' . $perusahaanMitra->id_perusahaan . '/edit-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-edit-alt"></i> Edit';
                $btn .= '</a></li>';

                // Delete link
                $btn .= '<li><a class="dropdown-item" href="' . url('perusahaan/' . $perusahaanMitra->id_perusahaan . '/confirm-ajax') . '" onclick="modalAction(this.href); return false;">';
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
        $jenisPerusahaan = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'jenis_perusahaan');
        })->get();
        return view('admin.perusahaan.create_ajax', compact('jenisPerusahaan'));
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
            'id_jenis_perusahaan' => 'required|exists:opsi_preferensi,id',
            'alamat'          => 'required|string',
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email,' . $request->id . ',id_perusahaan',
            'telepon'         => 'required|string|max:20',
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'errors'   => $validator->errors(),
            ], 422);
        }

        $pathLogo = null;
        if ($request->hasFile('logo')) {
            $pathLogo = 'storage/' . $request->file('logo')->store('logo_perusahaan', 'public');
        }

        PerusahaanMitra::create($request->only([
            'nama_perusahaan',
            'bidang_industri',
            'id_jenis_perusahaan',
            'alamat',
            'email',
            'telepon'
        ]) + [
            'path_logo' => $pathLogo,
        ]);


        return response()->json([
            'status'  => true,
            'message' => 'Data perusahaan berhasil disimpan',
        ]);
    }

    public function edit_ajax($id)
    {
        $perusahaan = PerusahaanMitra::with('jenisPerusahaan')->find($id);

        if (!$perusahaan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $jenisPerusahaan = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'jenis_perusahaan');
        })->get();

        return view('admin.perusahaan.edit_ajax', compact('perusahaan', 'jenisPerusahaan'));
    }


    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
            'id_jenis_perusahaan' => 'required|exists:opsi_preferensi,id',
            'alamat'          => 'required|string',
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email,' . $id . ',id_perusahaan',
            'telepon'         => 'required|string|max:20',
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hapus_logo'      => 'nullable|boolean',
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

        $pathLogo = $perusahaan->path_logo;

        // Handle penghapusan logo jika checkbox dicentang
        if ($request->has('hapus_logo') && $request->hapus_logo == '1') {
            if ($perusahaan->path_logo && Storage::disk('public')->exists($perusahaan->path_logo)) {
                Storage::disk('public')->delete($perusahaan->path_logo);
            }
            $pathLogo = 'storage/logo_perusahaan/logo-default.jpg';
        }
        // Handle upload logo baru
        elseif ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($perusahaan->path_logo && Storage::disk('public')->exists($perusahaan->path_logo)) {
                Storage::disk('public')->delete($perusahaan->path_logo);
            }
            
            $pathLogo = $request->file('logo')->store('logo_perusahaan', 'public');
            $pathLogo = 'storage/'.$pathLogo; 
        }

        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_industri' => $request->bidang_industri,
            'id_jenis_perusahaan' => $request->id_jenis_perusahaan,
            'alamat'          => $request->alamat,
            'email'           => $request->email,
            'telepon'         => $request->telepon,
            'path_logo'       => $pathLogo ?? $perusahaan->path_logo,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate',
            'logo_url' => $pathLogo ? asset('storage/'.$pathLogo) : null
        ]);
    }

    public function show_ajax($id)
    {
        $perusahaan = PerusahaanMitra::with('jenisPerusahaan')->find($id);

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
