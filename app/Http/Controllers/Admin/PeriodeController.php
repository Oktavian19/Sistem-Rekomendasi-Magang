<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeMagang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;    
use Carbon\Carbon;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = PeriodeMagang::all();
        return view('admin.periode.index', compact('periode'));
    }

    public function list(Request $request)
    {
        $periode = PeriodeMagang::select('id_periode', 'nama_periode', 'tanggal_mulai', 'tanggal_selesai', 'status');

        if ($request->has('id_periode')) {
            $periode->where('id_periode', $request->id_periode);
        }

        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('tanggal_mulai', function ($periode) {
                return Carbon::parse($periode->tanggal_mulai)->translatedFormat('d F Y'); // contoh: 11 Juni 2025
            })
            ->addColumn('tanggal_selesai', function ($periode) {
                return Carbon::parse($periode->tanggal_selesai)->translatedFormat('d F Y');
            })
            ->addColumn('status', function ($periode) {
                $class = $periode->status === 'aktif' ? 'badge bg-success' : 'badge bg-secondary';
                return '<span class="' . $class . '">' . ucfirst($periode->status) . '</span>';
            })
            ->addColumn('aksi', function ($periode) {
                $btn  = '<div class="dropdown">';
                $btn .= '<a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false">';
                $btn .= '<i class="bx bx-dots-vertical-rounded"></i>';
                $btn .= '</a>';
                $btn .= '<ul class="dropdown-menu">';

                // Edit link
                $btn .= '<li><a class="dropdown-item" href="' . url('periode/' . $periode->id_periode . '/edit-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-edit-alt"></i> Edit';
                $btn .= '</a></li>';

                // Delete link
                $btn .= '<li><a class="dropdown-item" href="' . url('periode/' . $periode->id_periode . '/confirm-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-trash"></i> Hapus';
                $btn .= '</a></li>';

                $btn .= '</ul>';
                $btn .= '</div>';

                return $btn;
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    // === AJAX ===
    public function create_ajax()
    {
        return view('admin.periode.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'nama_periode'     => 'required|string|max:100',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        // Ubah semua periode sebelumnya menjadi non-aktif
        PeriodeMagang::where('status', 'aktif')->update(['status' => 'non-aktif']);

        // Simpan periode baru dengan status default 'aktif'
        PeriodeMagang::create($request->only([
            'nama_periode',
            'tanggal_mulai',
            'tanggal_selesai',
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Periode berhasil disimpan dan status sebelumnya dinonaktifkan',
        ]);
    }


    public function edit_ajax(string $id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        return view('admin.periode.edit_ajax', compact('periode'));
    }

    public function update_ajax(Request $request, string $id)
    {
        $rules = [
            'nama_periode'     => 'required|string|max:100',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $periode->update($request->only([
            'nama_periode',
            'tanggal_mulai',
            'tanggal_selesai',
        ]));

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function show_ajax(string $id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.periode.show_ajax', compact('periode'));
    }

    public function confirm_ajax($id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.periode.confirm_ajax', compact('periode'));
    }

    public function delete_ajax($id)
    {
        $periode = PeriodeMagang::find($id);

        if (!$periode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $periode->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
