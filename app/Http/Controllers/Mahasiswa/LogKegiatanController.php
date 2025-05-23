<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LogKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DokumenLogKegiatan;
use Illuminate\Support\Facades\Storage;

class LogKegiatanController extends Controller
{
    public function index()
    {
        $idMahasiswa = Auth::user()->mahasiswa->id_mahasiswa;

        $logs = LogKegiatan::whereHas('magang.lamaran', function ($query) use ($idMahasiswa) {
            $query->where('id_mahasiswa', $idMahasiswa);
        })
            ->with(['magang.lamaran.lowongan', 'dokumen'])
            ->latest('tanggal')
            ->paginate(10);

        return view('mahasiswa.log.index', compact('logs'));
    }

    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa || !$mahasiswa->lowongan) {
            return redirect()->back()->with('error', 'Data lowongan tidak ditemukan.');
        }

        $durasi = $mahasiswa->lowongan->durasi_magang;
        $jumlahMinggu = $durasi * 4; // 1 bulan = 4 minggu

        return view('mahasiswa.log.create', compact('jumlahMinggu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_kegiatan' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Create log kegiatan
        $log = LogKegiatan::create([
            'id_magang' => Auth::user()->mahasiswa->id_magang,
            'tanggal' => $request->tanggal,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'minggu' => $request->minggu
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/log-kegiatan');
                $publicPath = str_replace('public/', 'storage/', $path);

                DokumenLogKegiatan::create([
                    'id_log_kegiatan' => $log->id,
                    'path_file' => $publicPath,
                    'nama_file' => $image->getClientOriginalName(),
                    'tipe_file' => $image->getClientMimeType()
                ]);
            }
        }

        return redirect()->route('log-kegiatan.index')->with('success', 'Log berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $log = LogKegiatan::with('dokumen')->findOrFail($id);
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa || !$mahasiswa->lowongan) {
            return redirect()->back()->with('error', 'Data lowongan tidak ditemukan.');
        }

        $durasi = $mahasiswa->lowongan->durasi_magang;
        $jumlahMinggu = $durasi * 4;

        return view('mahasiswa.log.edit', compact('log', 'jumlahMinggu'));
    }

    public function update(Request $request, $id)
    {
        $log = LogKegiatan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_kegiatan' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $log->update([
            'tanggal' => $request->tanggal,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'minggu' => $request->minggu
        ]);

        // Handle removed images
        if ($request->has('removed_image_ids')) {
            foreach ($request->removed_image_ids as $imageId) {
                $dokumen = DokumenLogKegiatan::find($imageId);
                if ($dokumen) {
                    // Delete physical file
                    $storagePath = str_replace('storage/', 'public/', $dokumen->path_file);
                    Storage::delete($storagePath);

                    // Delete database record
                    $dokumen->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/log-kegiatan');
                $publicPath = str_replace('public/', 'storage/', $path);

                DokumenLogKegiatan::create([
                    'id_log_kegiatan' => $log->id,
                    'path_file' => $publicPath,
                    'nama_file' => $image->getClientOriginalName(),
                    'tipe_file' => $image->getClientMimeType()
                ]);
            }
        }

        return redirect()->route('log-kegiatan.index')->with('success', 'Log berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $log = LogKegiatan::with('dokumen')->findOrFail($id);

        // Delete all related documents
        if ($log->dokumen) {
            foreach ($log->dokumen as $dokumen) {
                $storagePath = str_replace('storage/', 'public/', $dokumen->path_file);
                Storage::delete($storagePath);
                $dokumen->delete();
            }
        }

        $log->delete();

        return redirect()->route('log-kegiatan.index')->with('success', 'Log berhasil dihapus.');
    }
}
