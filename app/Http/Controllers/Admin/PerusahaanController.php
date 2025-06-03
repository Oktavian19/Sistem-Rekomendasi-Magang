<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanMitra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
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
        $query = PerusahaanMitra::select('id_perusahaan', 'nama_perusahaan', 'bidang_industri', 'email', 'telepon', 'alamat');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        if ($request->filled('bidang_industri')) {
            $query->where('bidang_industri', $request->bidang_industri);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($perusahaanMitra) {
                $btn  = '<div class="dropdown">';
                $btn .= '<a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false">';
                $btn .= '<i class="bx bx-dots-vertical-rounded"></i>';
                $btn .= '</a>';
                $btn .= '<ul class="dropdown-menu">';

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
        return view('admin.perusahaan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'nama_perusahaan' => 'required|string|max:100',
            'bidang_industri' => 'required|string|max:100',
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


        // Geocoding berdasarkan alamat
        $geo = $this->getCoordinates($request->alamat);

        PerusahaanMitra::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_industri' => $request->bidang_industri,
            'alamat'          => $request->alamat,
            'email'           => $request->email,
            'telepon'         => $request->telepon,
            'path_logo'       => $pathLogo,
            'latitude'        => $geo['lat'] ?? null,
            'longitude'       => $geo['lon'] ?? null,
        ]);


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
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($perusahaan->path_logo && Storage::disk('public')->exists($perusahaan->path_logo)) {
                Storage::disk('public')->delete($perusahaan->path_logo);
            }

            // Simpan logo baru
            $pathLogo = $request->file('logo')->store('logo_perusahaan', 'public');
        } else {
            $pathLogo = $perusahaan->path_logo;
        }



        // Geocode alamat baru
        $geo = $this->getCoordinates($request->alamat);

        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_industri' => $request->bidang_industri,
            'alamat'          => $request->alamat,
            'email'           => $request->email,
            'telepon'         => $request->telepon,
            'path_logo'       => $pathLogo ?? $perusahaan->path_logo,
            'latitude'        => $geo['lat'] ?? null,
            'longitude'       => $geo['lon'] ?? null,
        ]);


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

    private function getCoordinates($alamat)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'MyApp/1.0 (your.email@example.com)',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $alamat,
            'format' => 'json',
            'limit' => 1,
        ]);

        if ($response->successful() && !empty($response[0])) {
            return [
                'lat' => $response[0]['lat'],
                'lon' => $response[0]['lon'],
            ];
        }

        return null;
    }
}
