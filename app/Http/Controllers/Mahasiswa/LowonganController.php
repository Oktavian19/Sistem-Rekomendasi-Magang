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
        // Gunakan array dalam with()
        $query = Lowongan::with(['perusahaan', 'bidangKeahlian']);

        // Hitung total sebelum filter
        $total = $query->count();

        // Filter: Keyword posisi
        if ($request->filled('keyword')) {
            $query->where('nama_posisi', 'like', '%' . $request->keyword . '%');
        }

        // Filter: Lokasi perusahaan
        if ($request->filled('lokasi')) {
            $query->whereHas('perusahaan', function ($q) use ($request) {
                $q->where('alamat', 'like', '%' . $request->lokasi . '%');
            });
        }

        // Filter: Bidang Keahlian (relasi melalui preferensi)
        if ($request->filled('job_field_id')) {
            $query->whereHas('bidangKeahlian', function ($q) use ($request) {
                $q->where('id', $request->job_field_id);
            });
        }

        // Filter: Kuota
        if ($request->filled('quota_range')) {
            $range = $request->quota_range;
            if ($range === '51+') {
                $query->where('kuota', '>', 50);
            } elseif (str_contains($range, '-')) {
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
                break;
        }

        // Pagination
        $lowongans = $query->paginate(12)->appends($request->query());

        // Ambil kota dari alamat perusahaan (2 elemen dari belakang)
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

        // Ambil bidang keahlian (opsi preferensi dengan kode = bidang_keahlian)
        $bidangKeahlians = OpsiPreferensi::whereHas('kategori', function ($q) {
            $q->where('kode', 'bidang_keahlian');
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

        $jumlahPelamar = Lamaran::where('id_lowongan', $id)->count();

        return view('mahasiswa.magang.lowongan_detail', compact('lowongan', 'sudahDaftar', 'jumlahPelamar'));
    }



    public function daftarLamaran(Request $request, $id)
    {
        $mahasiswaId = Auth::id();

        // Cek apakah sudah pernah mendaftar
        $sudahDaftar = Lamaran::where('id_mahasiswa', $mahasiswaId)
            ->where('id_lowongan', $id)
            ->exists();

        $sedangDaftar = Lamaran::where('id_mahasiswa', $mahasiswaId)
            ->whereIn('status_lamaran', ['diprosesAdmin', 'diprosesPerusahaan'])
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah mendaftar pada lowongan ini.');
        } elseif ($sedangDaftar) {
            return back()->with('error', 'Tunggu Lamaran lainmu dulu, ya');
        }

        Lamaran::create([
            'id_mahasiswa'     => $mahasiswaId,
            'id_lowongan'      => $id,
            'tanggal_lamaran'  => now(),
            'status_lamaran'   => 'diprosesAdmin',
            'dari_rekomendasi' => $request->boolean('dari_rekomendasi'), // Ambil dari form
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }
}
