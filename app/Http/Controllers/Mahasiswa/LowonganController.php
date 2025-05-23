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
            $query->where('nama_posisi', 'like', '%' . $request->keyword . '%');
        }

        // Filter: Lokasi (kota)
        if ($request->filled('lokasi')) {
            $query->whereHas('perusahaan', function ($q) use ($request) {
                $q->where('alamat', 'LIKE', '%' . $request->lokasi . '%');
            });
        }

        // Filter: Bidang pekerjaan
        if ($request->filled('job_field_id')) {
            $query->where('id_bidang_keahlian', $request->job_field_id);
        }

        // Filter: Kuota (diubah untuk menerima single value)
        if ($request->filled('quota_range')) {
            $range = $request->quota_range;
            if ($range === '51+') {
                $query->where('kuota', '>', 50);
            } else {
                [$min, $max] = explode('-', $range);
                $query->whereBetween('kuota', [(int) $min, (int) $max]);
            }
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

        return view('mahasiswa.magang.lowongan', compact('total', 'lowongans', 'kotas', 'bidangKeahlians'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan', 'bidangKeahlian'])->findOrFail($id);
        return view('mahasiswa.magang.lowongan_detail', compact('lowongan'));
    }
}
