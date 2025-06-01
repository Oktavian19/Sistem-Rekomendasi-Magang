<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LogKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DokumenLogKegiatan;
use Illuminate\Support\Facades\Storage;
use App\Models\Magang;

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

        // Cek apakah ada data mahasiswa
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan.'
            ], 422);
        }

        $pendaftaran = Magang::with('lamaran.lowongan.durasiMagang')
            ->whereHas('lamaran', function ($query) {
                $query->where('id_mahasiswa', auth()->user()->id_user);
            })->first();

        if (!$pendaftaran || $pendaftaran->status_magang !== 'aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Status magang tidak aktif.'
            ], 422);
        }

        $label = $pendaftaran->lamaran->lowongan->durasiMagang->label;

        // Ambil angka dari string, misalnya '3 Bulan' -> 3
        preg_match('/\d+/', $label, $matches);
        $durasi = isset($matches[0]) ? (int) $matches[0] : 0;

        // Ubah bulan ke minggu
        $jumlahMinggu = $durasi * 4;

        return view('mahasiswa.log.create', compact('jumlahMinggu'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'minggu' => 'required|integer|min:1',
            'deskripsi_kegiatan' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'images' => 'nullable|array|max:5',
        ]);

        try {
            // Get authenticated user's mahasiswa data
            $mahasiswa = Auth::user()->mahasiswa;

            if (!$mahasiswa) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data mahasiswa tidak ditemukan.');
            }

            // Get the latest active magang
            $lamaran = $mahasiswa->lamaran()
                ->whereHas('magang', function ($query) {
                    $query->where('status_magang', 'aktif'); // Only active magang
                })
                ->latest()
                ->first();

            if (!$lamaran || !$lamaran->magang) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anda belum memiliki magang yang aktif.');
            }

            // Create log kegiatan
            $log = LogKegiatan::create([
                'id_magang' => $lamaran->magang->id_magang,
                'tanggal' => $validated['tanggal'],
                'deskripsi_kegiatan' => $validated['deskripsi_kegiatan'],
                'minggu' => $validated['minggu']
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/log-kegiatan');
                    $publicPath = str_replace('public/', 'storage/', $path);

                    DokumenLogKegiatan::create([
                        'id_log' => $log->id_log,
                        'path_file' => $publicPath,
                        'nama_file' => $image->getClientOriginalName() // Store original filename
                    ]);
                }
            }

            return redirect(url('/log-kegiatan'))
                ->with('success', 'Log kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $log = LogKegiatan::with('dokumen')->find($id);
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan.'
            ], 422);
        }

        // Ambil data pendaftaran magang yang aktif
        $pendaftaran = Magang::with('lamaran.lowongan.durasiMagang')
            ->whereHas('lamaran', function ($query) {
                $query->where('id_mahasiswa', auth()->user()->id_user);
            })->first();

        if (!$pendaftaran || $pendaftaran->status_magang !== 'aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Status magang tidak aktif.'
            ], 422);
        }

        $label = optional(optional($pendaftaran->lamaran)->lowongan->durasiMagang)->label;
        if (!$label) {
            return response()->json([
                'status' => 'error',
                'message' => 'Durasi magang tidak ditemukan.'
            ], 422);
        }

        // Ambil angka dari label, contoh: "3 Bulan" -> 3
        preg_match('/\d+/', $label, $matches);
        $durasi = isset($matches[0]) ? (int) $matches[0] : 0;

        // Konversi bulan ke minggu
        $jumlahMinggu = $durasi * 4;

        return view('mahasiswa.log.edit', compact('log', 'jumlahMinggu'));
    }

    public function update(Request $request, $id)
    {
        $log = LogKegiatan::findOrFail($id);
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa || !$mahasiswa->lamaran()->whereHas('magang', function ($q) use ($log) {
            $q->where('id_magang', $log->id_magang);
        })->exists()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memperbarui log ini.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'minggu' => 'required|integer|min:1',
            'deskripsi_kegiatan' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'images' => 'nullable|array|max:5',
        ]);

        try {
            // ❗ Jika ada gambar baru diupload
            if ($request->hasFile('images')) {
                // Hapus semua gambar lama
                foreach ($log->dokumen as $dokumen) {
                    $storagePath = str_replace('storage/', 'public/', $dokumen->path_file);
                    Storage::delete($storagePath);
                    $dokumen->delete();
                }

                // Simpan gambar baru
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/log-kegiatan');
                    $publicPath = str_replace('public/', 'storage/', $path);

                    DokumenLogKegiatan::create([
                        'id_log' => $log->id_log,
                        'path_file' => $publicPath,
                        'nama_file' => $image->getClientOriginalName()
                    ]);
                }
            }

            // Update log
            $log->update([
                'tanggal' => $validated['tanggal'],
                'deskripsi_kegiatan' => $validated['deskripsi_kegiatan'],
                'minggu' => $validated['minggu']
            ]);

            return redirect(url('/log-kegiatan'))->with('success', 'Log kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $log = LogKegiatan::findOrFail($id);

            // Hapus semua file gambar terkait sebelum hapus log
            foreach ($log->dokumen as $dokumen) {
                $storagePath = str_replace('storage/', 'public/', $dokumen->path_file);
                Storage::delete($storagePath);
            }

            // Hapus data log (dan relasi dokumen jika cascade delete tidak aktif)
            $log->delete();

            return response()->json([
                'success' => true,
                'message' => 'Log kegiatan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus log kegiatan'
            ], 500);
        }
    }
}
