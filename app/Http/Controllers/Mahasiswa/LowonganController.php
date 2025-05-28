<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\OpsiPreferensi;
use Illuminate\Support\Facades\Auth;

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
        $bidangKeahlians = OpsiPreferensi::whereHas('kategori', function ($query) {
                $query->where('kode', 'bidang_keahlian');
            })->get();

        return view('mahasiswa.magang.lowongan', compact('total', 'lowongans', 'kotas', 'bidangKeahlians'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan', 'bidangKeahlian'])->findOrFail($id);

        $mahasiswaId = Auth::id();

        $sudahDaftar = Lamaran::where('id_mahasiswa', $mahasiswaId)
            ->where('id_lowongan', $id)
            ->exists();

        return view('mahasiswa.magang.lowongan_detail', compact('lowongan', 'sudahDaftar'));
    }


    public function daftarLamaran(Request $request, $id)
    {
        $mahasiswaId = Auth::id(); // Langsung pakai Auth default

        // Cek apakah sudah pernah mendaftar
        $sudahDaftar = Lamaran::where('id_mahasiswa', $mahasiswaId)
            ->where('id_lowongan', $id)
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah mendaftar pada lowongan ini.');
        }

        Lamaran::create([
            'id_mahasiswa'     => $mahasiswaId,
            'id_lowongan'      => $id,
            'tanggal_lamaran'  => now(),
            'status_lamaran'   => 'Menunggu',
            'dari_rekomendasi' => false,
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }
}
