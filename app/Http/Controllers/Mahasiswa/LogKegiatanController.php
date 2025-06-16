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
            ->whereHas('magang', function ($query) {
                $query->where('status_magang', 'aktif');
            })
            ->with(['magang.lamaran.lowongan', 'dokumen', 'feedback.user'])
            ->latest('tanggal')
            ->paginate(10);

        $isMagangAktif = Magang::whereHas('lamaran', function ($query) use ($idMahasiswa) {
            $query->where('id_mahasiswa', $idMahasiswa);
        })
            ->where('status_magang', 'aktif')
            ->exists();

        return view('mahasiswa.log.index', compact('logs', 'isMagangAktif'));
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
                'message' => 'Status magang tidak aktif. Anda tidak dapat membuat log kegiatan saat status magang tidak aktif.'
            ], 422);
        }

        // Cek apakah sudah memiliki dosen pembimbing
        if (is_null($pendaftaran->id_dosen_pembimbing)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum memiliki dosen pembimbing. Tidak dapat membuat log kegiatan.'
            ], 422);
        }

        $label = $pendaftaran->lamaran->lowongan->durasiMagang->label;

        // Ambil angka dari string, misalnya '3 Bulan' -> 3
        preg_match('/\d+/', $label, $matches);
        $durasi = isset($matches[0]) ? (int) $matches[0] : 0;

        // Ubah bulan ke minggu
        $jumlahMinggu = $durasi * 4;
        $magangAktif = $pendaftaran;

        $mingguTerpakai = LogKegiatan::where('id_magang', $magangAktif->id_magang)
            ->whereNotNull('minggu')
            ->pluck('minggu')
            ->toArray();

        return view('mahasiswa.log.create', compact('jumlahMinggu', 'mingguTerpakai'));
    }


    public function store(Request $request)
    {
        $messages = [
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'minggu.required' => 'Minggu ke- wajib diisi.',
            'minggu.integer' => 'Minggu harus berupa angka.',
            'minggu.min' => 'Minggu minimal :min.',
            'deskripsi_kegiatan.required' => 'Deskripsi kegiatan wajib diisi.',
            'images.max' => 'Maksimal boleh mengupload :max gambar.',
            'images.*.image' => 'File harus berupa gambar.',
        ];

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'minggu' => 'required|integer|min:1|max:52',
            'deskripsi_kegiatan' => 'required|string|max:1000',
            'images.*' => 'nullable|image', // Hanya validasi tipe gambar
            'images' => 'nullable|array|max:5', // Validasi jumlah file
        ], $messages);

        try {
            // Get authenticated user's mahasiswa data
            $mahasiswa = Auth::user()->mahasiswa;

            if (!$mahasiswa) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data mahasiswa tidak ditemukan.');
            }

            // Validasi tanggal tidak boleh lebih besar dari hari ini
            if ($validated['tanggal'] > now()->toDateString()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Tanggal tidak boleh lebih besar dari hari ini.');
            }

            // Get the latest active magang
            $lamaran = $mahasiswa->lamaran()
                ->whereHas('magang', function ($query) {
                    $query->where('status_magang', 'aktif');
                })
                ->latest()
                ->first();

            if (!$lamaran || !$lamaran->magang) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anda belum memiliki magang yang aktif.');
            }

            // Validasi duplikasi log kegiatan di tanggal yang sama
            $existingLog = LogKegiatan::where('id_magang', $lamaran->magang->id_magang)
                ->where('tanggal', $validated['tanggal'])
                ->first();

            if ($existingLog) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anda sudah membuat log kegiatan untuk tanggal ini.');
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
                $images = $request->file('images');

                // Cek ulang jumlah file
                if (count($images) > 5) {
                    return redirect()->back()->withInput()
                        ->with('error', 'Maksimal hanya boleh mengunggah 5 gambar.');
                }

                $maxFileSize = 2 * 1024 * 1024; // 2MB per file
                $maxTotalSize = 10 * 1024 * 1024; // 10MB total
                $totalSize = 0;

                foreach ($images as $image) {
                    if (!$image->isValid()) {
                        return redirect()->back()->withInput()
                            ->with('error', 'Terdapat file yang tidak valid.');
                    }

                    if ($image->getSize() > $maxFileSize) {
                        return redirect()->back()->withInput()
                            ->with('error', 'Ukuran tiap gambar maksimal 2MB.');
                    }

                    $totalSize += $image->getSize();
                }

                if ($totalSize > $maxTotalSize) {
                    return redirect()->back()->withInput()
                        ->with('error', 'Total ukuran semua gambar maksimal 10MB.');
                }

                // Simpan gambar setelah semua validasi lolos
                foreach ($images as $image) {
                    $path = $image->store('public/log-kegiatan');
                    $publicPath = str_replace('public/', 'storage/', $path);

                    DokumenLogKegiatan::create([
                        'id_log' => $log->id_log,
                        'path_file' => $publicPath,
                        'nama_file' => $image->getClientOriginalName()
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
