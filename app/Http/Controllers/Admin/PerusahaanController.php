<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $query = PerusahaanMitra::select('id_perusahaan', 'nama_perusahaan', 'bidang_industri', 'email', 'telepon', 'alamat');

        if ($request->has('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
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
            'email'           => 'required|email|max:100|unique:perusahaan_mitra,email',
            'telepon'         => 'required|string|max:20',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'errors'   => $validator->errors(),
            ], 422);
        }

        // Geocoding berdasarkan alamat
        $geo = $this->getCoordinates($request->alamat);

        PerusahaanMitra::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_industri' => $request->bidang_industri,
            'alamat'          => $request->alamat,
            'email'           => $request->email,
            'telepon'         => $request->telepon,
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

        // Geocode alamat baru
        $geo = $this->getCoordinates($request->alamat);

        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'bidang_industri' => $request->bidang_industri,
            'alamat'          => $request->alamat,
            'email'           => $request->email,
            'telepon'         => $request->telepon,
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
    $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
        'q' => $alamat,
        'format' => 'json',
        'limit' => 1
    ]);

    $opts = [
        "http" => [
            "header" => "User-Agent: MyApp/1.0 (your.email@example.com)\r\n"
        ]
    ];

    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    $data = json_decode($response, true);
    if (!empty($data)) {
        return [
            'lat' => $data[0]['lat'],
            'lon' => $data[0]['lon'],
        ];
    }

    return null;
}

}
