<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index(Request $request)
{
    $query = Lowongan::with('perusahaan');

    if ($request->filled('keyword')) {
        $query->where('nama_posisi', 'like', '%' . $request->keyword . '%');
    }

    if ($request->filled('province_id')) {
        $query->whereHas('perusahaan', function ($q) use ($request) {
            $q->where('province_id', $request->province_id);
        });
    }

    if ($request->filled('job_field_id')) {
        $query->where('kategori_keahlian', $request->job_field_id);
    }

    if ($request->filled('quota_range')) {
        $query->where(function ($q) use ($request) {
            foreach ($request->quota_range as $range) {
                if ($range == '51+') {
                    $q->orWhere('kuota', '>', 50);
                } else {
                    [$min, $max] = explode('-', $range);
                    $q->orWhereBetween('kuota', [(int)$min, (int)$max]);
                }
            }
        });
    }

    switch ($request->input('sort')) {
        case 'oldest':
            $query->orderBy('tanggal_buka', 'asc');
            break;
        case 'name_asc':
            $query->orderBy('nama_posisi', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('nama_posisi', 'desc');
            break;
        default:
            $query->orderBy('tanggal_buka', 'desc');
    }

    $lowongan = $query->paginate(12)->appends($request->query());
    $totalLowongan = Lowongan::count();

    if ($request->ajax()) {
        return view('mahasiswa.magang.partials.lowongan-list', compact('lowongan'))->render();
    }

    return view('mahasiswa.magang.lowongan', compact('lowongan', 'totalLowongan'));
}

}
