<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BidangKeahlian;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Provinsi;
use App\Models\BidangPekerjaan;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with('perusahaan');

        $total = $query->count();

        // Filter: Keyword
        if ($request->filled('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%');
        }

        // Filter: Lokasi (kota)
        if ($request->filled('lokasi')) {
            $query->whereHas('perusahaan', function ($q) use ($request) {
                $q->where('alamat', 'LIKE', '%' . $request->lokasi . '%');
            });
        }

        // Filter: Bidang pekerjaan
        if ($request->filled('job_field_id')) {
            $query->where('id_bidang_pekerjaan', $request->job_field_id);
        }

        // Filter: Kuota
        if ($request->filled('quota_range')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->quota_range as $range) {
                    if ($range === '51+') {
                        $q->orWhere('kuota', '>', 50);
                    } else {
                        [$min, $max] = explode('-', $range);
                        $q->orWhereBetween('kuota', [(int) $min, (int) $max]);
                    }
                }
            });
        }

        // Sorting
        switch ($request->get('sort')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama_posisi', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_posisi', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $lowongans = $query->paginate(12)->appends(request()->query());

        // Ambil kota unik dari alamat perusahaan (ketiga dari belakang)
        $kotas = Lowongan::with('perusahaan')
            ->get()
            ->map(function ($lowongan) {
                $alamat = $lowongan->perusahaan->alamat ?? '';
                $parts = array_map('trim', explode(',', $alamat));
                return count($parts) >= 3 ? $parts[count($parts) - 2] : null;
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();

        // Ambil bidang pekerjaan untuk filter
        $bidangKeahlians = BidangKeahlian::all();

        // Untuk kebutuhan tampilan filter (optional)
        $filters = [
            'keyword' => $request->keyword,
            'lokasi' => $request->lokasi,
            'job_field_id' => $request->job_field_id,
            'quota_range' => $request->quota_range,
            'sort' => $request->sort,
        ];

        return view('mahasiswa.magang.lowongan', compact('total', 'lowongans', 'kotas', 'bidangKeahlians', 'filters'));
    }
}
