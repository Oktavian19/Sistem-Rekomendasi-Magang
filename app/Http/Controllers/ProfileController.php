<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Pengalaman;
use App\Models\Dokumen;
use App\Models\ProgramStudi;
use App\Models\DosenPembimbing;
use App\Models\Admin;
use App\Models\KategoriPreferensi;
use App\Models\OpsiPreferensi;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $role = Auth::user()->role;

        if ($role == 'mahasiswa') {
            $mahasiswa = Mahasiswa::with([
                'pengalamanKerja',
                'dokumen',
                'programStudi',
                'opsiPreferensi' => function ($query) {
                    $query->orderBy('preferensi_pengguna.ranking');
                }
            ])
            ->where('id_mahasiswa', $userId)
            ->first();

            if (!$mahasiswa) {
                abort(404, 'Mahasiswa tidak ditemukan untuk user ID: ' . $userId);
            }

            return view('mahasiswa.profile.index', compact('mahasiswa'));
        } else if ($role == 'dosen_pembimbing') {
            $dosen = DosenPembimbing::where('id_dosen_pembimbing', $userId)->first();

            if (!$dosen) {
                abort(404, 'Dosen tidak ditemukan untuk user ID: ' . $userId);
            }

            return view('dosen.profile.index', compact('dosen'));
        } else if ($role == 'admin') {
            $admin = Admin::where('id_admin', $userId)->first();

            if (!$admin) {
                abort(404, 'Admin tidak ditemukan untuk user ID: ' . $userId);
            }

            return view('admin.profile.index', compact('admin'));
        }
    }

    public function edit()
    {
        $userId = Auth::id();
        $role = Auth::user()->role;

        if ($role == 'mahasiswa') {
            $mahasiswa = Mahasiswa::with([
                'pengalamanKerja',
                'dokumen',
                'programStudi',
                'opsiPreferensi' => function ($query) {
                    $query->orderBy('preferensi_pengguna.ranking');
                }
            ])
            ->where('id_mahasiswa', $userId)
            ->first();

            if (!$mahasiswa) {
                return response()->json(['error' => 'Data mahasiswa tidak ditemukan.'], 404);
            }

            $programStudi = ProgramStudi::all();
            $jarak = OpsiPreferensi::whereHas('kategori', function ($query) {
                $query->where('kode', 'jarak');
            })->get();
            $jenisPerusahaan = OpsiPreferensi::whereHas('kategori', function ($query) {
                $query->where('kode', 'jenis_perusahaan');
            })->get();
            $bidangKeahlian = OpsiPreferensi::whereHas('kategori', function ($query) {
                $query->where('kode', 'bidang_keahlian');
            })->get();
            $fasilitas = OpsiPreferensi::whereHas('kategori', function ($query) {
                $query->where('kode', 'fasilitas');
            })->get();
            $durasi = OpsiPreferensi::whereHas('kategori', function ($query) {
                $query->where('kode', 'durasi_magang');
            })->get();

            return view('mahasiswa.profile.edit_profile', compact('mahasiswa', 'programStudi', 'jarak', 'jenisPerusahaan', 'bidangKeahlian', 'fasilitas', 'durasi'));
        } elseif ($role == 'dosen_pembimbing') {
            $dosen = DosenPembimbing::where('id_dosen_pembimbing', $userId)->first();

            if (!$dosen) {
                return response()->json(['error' => 'Data dosen pembimbing tidak ditemukan.'], 404);
            }

            return view('dosen.profile.edit', compact('dosen'));
        } elseif ($role == 'admin') {
            $admin = Admin::where('id_admin', $userId)->first();

            if (!$admin) {
                return response()->json(['error' => 'Data admin tidak ditemukan.'], 404);
            }

            return view('admin.profile.edit', compact('admin'));
        } else {
            abort(403, 'Role tidak dikenali');
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mahasiswa,email,' . Auth::id() . ',id_mahasiswa',
            'no_hp' => 'required|string|max:20',
            'id_program_studi' => 'required|exists:program_studi,id_program_studi',
            'alamat' => 'nullable|string|max:500',
            'jarak' => 'nullable|array',
            'jarak.*' => 'exists:opsi_preferensi,id',
            'jenis_perusahaan' => 'nullable|array',
            'jenis_perusahaan.*' => 'exists:opsi_preferensi,id',
            'bidang_keahlian' => 'nullable|array',
            'bidang_keahlian.*' => 'exists:opsi_preferensi,id',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:opsi_preferensi,id',
            'durasi' => 'nullable|array',
            'durasi.*' => 'exists:opsi_preferensi,id',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();

        if ($request->hasFile('foto_profil')) {
            if ($mahasiswa->foto_profil && Storage::exists(str_replace('/storage/', 'public/', $mahasiswa->foto_profil))) {
                Storage::delete(str_replace('/storage/', 'public/', $mahasiswa->foto_profil));
            }

            $foto = $request->file('foto_profil');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('public/foto_profil/mahasiswa', $namaFile);
            $validated['foto_profil'] = Storage::url($path);
        }

        // Update data utama
        $mahasiswa->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'id_program_studi' => $validated['id_program_studi'],
            'alamat' => $validated['alamat'] ?? null,
            'foto_profil' => $validated['foto_profil'] ?? null
        ]);

        // --- Prepare Preferences for Synchronization with Pivot Values ---
        $allPreferensiWithPivot = [];

        // 1. Preferensi Jarak (Ordered, points based on fixed array)
        $jarakIds = $validated['jarak'] ?? [];
        $opsiPoinJarak = [10, 5, 3]; // Points for rank 1, 2, 3
        foreach ($jarakIds as $index => $id) {
            $ranking = $index + 1;
            $poin = $opsiPoinJarak[$index] ?? 0; // Default to 0 if index out of bounds
            $allPreferensiWithPivot[(int)$id] = [ // Cast ID to integer to be safe
                'ranking' => $ranking,
                'poin' => $poin,
            ];
        }

        // 2. Preferensi Durasi Magang (Ordered, points based on fixed array)
        $durasiIds = $validated['durasi'] ?? []; // Frontend sends IDs for Durasi now, not '3' or '6'
        $opsiPoinDurasi = [7, 5]; // Points for rank 1, 2
        foreach ($durasiIds as $index => $id) { // Loop through the IDs directly
            // No need to query OpsiPreferensi here, as frontend sends the ID
            $ranking = $index + 1;
            $poin = $opsiPoinDurasi[$index] ?? 0; // Default to 0 if index out of bounds
            $allPreferensiWithPivot[(int)$id] = [ // Cast ID to integer and use it directly
                'ranking' => $ranking,
                'poin' => $poin,
            ];
        }

        // 3. Preferensi Jenis Perusahaan (Ordered, points based on calculation)
        $jenisPerusahaanIds = $validated['jenis_perusahaan'] ?? [];
        $num_options_jenis_perusahaan = count($jenisPerusahaanIds);
        foreach ($jenisPerusahaanIds as $index => $id) {
            $ranking = $index + 1;
            $poin = ($num_options_jenis_perusahaan - $index) * 3; // Points = (total_options - current_index) * 3
            $allPreferensiWithPivot[(int)$id] = [ // Cast ID to integer
                'ranking' => $ranking,
                'poin' => $poin,
            ];
        }

        // 4. Preferensi Bidang Keahlian (Ordered, points based on calculation)
        $bidangKeahlianIds = $validated['bidang_keahlian'] ?? [];
        $num_options_bidang_keahlian = count($bidangKeahlianIds);
        foreach ($bidangKeahlianIds as $index => $id) {
            $ranking = $index + 1;
            $poin = ($num_options_bidang_keahlian - $index) * 5; // Poin = (total_options - current_index) * 5
            $allPreferensiWithPivot[(int)$id] = [ // Cast ID to integer
                'ranking' => $ranking,
                'poin' => $poin,
            ];
        }

        // 5. Preferensi Fasilitas (Unordered, fixed point)
        foreach (($validated['fasilitas'] ?? []) as $id) {
            $allPreferensiWithPivot[(int)$id] = [ // Cast ID to integer
                'ranking' => null, // No specific ranking for facilities
                'poin' => 1,       // Fixed point for facilities as per seeder
            ];
        }
        
        // --- Synchronize all preferences with their ranking and points ---
        $mahasiswa->opsiPreferensi()->sync($allPreferensiWithPivot);

        if ($request->ajax()) {
            return response()->json(['message' => 'Profil berhasil diperbarui']);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    // --- Pengalaman Kerja ---

    // Tampilkan form tambah pengalaman kerja
    public function createPengalaman()
    {
        return view('mahasiswa.profile.create_pengalaman');
    }

    // Simpan pengalaman kerja baru
    public function storePengalaman(Request $request)
    {
        $request->validate([
            'perusahaan' => 'required|string|max:255',
            'nama_posisi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();

        Pengalaman::create([
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
            'perusahaan' => $request->perusahaan,
            'nama_posisi' => $request->nama_posisi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->back()->with('success', 'Pengalaman kerja berhasil ditambahkan.');
    }

    // Tampilkan form edit pengalaman kerja
    public function editPengalaman($id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();
        $pengalaman = Pengalaman::where('id_pengalaman', $id)
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->firstOrFail();

        return view('mahasiswa.profile.edit_pengalaman', compact('pengalaman'));
    }

    // Update pengalaman kerja
    public function updatePengalaman(Request $request, $id)
    {
        $request->validate([
            'perusahaan' => 'required|string|max:255',
            'nama_posisi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();
        $pengalaman = Pengalaman::where('id_pengalaman', $id)
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->firstOrFail();

        $pengalaman->update($request->only('perusahaan', 'nama_posisi', 'tanggal_mulai', 'tanggal_selesai'));

        return redirect()->back()->with('success', 'Pengalaman kerja berhasil diperbarui.');
    }

    // Hapus pengalaman kerja
    public function destroyPengalaman($id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();
        $pengalaman = Pengalaman::where('id_pengalaman', $id)
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->firstOrFail();

        $pengalaman->delete();

        return redirect()->back()->with('success', 'Pengalaman kerja berhasil dihapus.');
    }

    // --- Dokumen ---

    // Tampilkan form tambah dokumen
    public function createDokumen()
    {
        return view('mahasiswa.profile.create_dokumen'); // Buat view form upload dokumen
    }

    // Simpan dokumen baru
    public function storeDokumen(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required|string|in:Curriculum Vitae (CV),Ijazah,Transkrip Nilai,Sertifikat,KTP,NPWP,SIM,Lainnya',
            'path_file' => 'required|file|mimes:pdf|max:5120',
        ]);

        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->first();

        if ($request->jenis_dokumen === 'Curriculum Vitae (CV)') {
            $cvLama = Dokumen::where('id_user', $mahasiswa->id_mahasiswa)
                ->where('jenis_dokumen', 'Curriculum Vitae (CV)')
                ->first();

            if ($cvLama) {
                Storage::disk('public')->delete($cvLama->path_file);
                $cvLama->delete();
            }
        }


        $file = $request->file('path_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumen', $filename, 'public');

        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error', 'Gagal menyimpan file');
        }

        Dokumen::create([
            'id_user' => $mahasiswa->id_mahasiswa,
            'jenis_dokumen' => $request->jenis_dokumen,
            'path_file' => $path,
            'tanggal_upload' => now(),
        ]);


        return redirect()->back()->with('success', 'Dokumen berhasil diunggah.');
    }
    // Tampilkan form edit dokumen
    public function editDokumen($id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();
        $dokumen = Dokumen::where('id_dokumen', $id)
            ->where('id_user', $mahasiswa->id_mahasiswa)
            ->firstOrFail();

        return view('mahasiswa.profile.edit_dokumen', compact('dokumen'));
    }

    // Update dokumen (misal ganti file atau jenis dokumen)
    public function updateDokumen(Request $request, $id)
    {
        $request->validate([
            'jenis_dokumen' => 'required|string|in:Curriculum Vitae (CV),Ijazah,Transkrip Nilai,Sertifikat,KTP,NPWP,SIM,Lainnya',
            'path_file' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();

        $dokumen = Dokumen::where('id_dokumen', $id)
            ->where('id_user', $mahasiswa->id_mahasiswa)
            ->firstOrFail();

        // Jika ada file baru, hapus file lama lalu upload baru
        if ($request->hasFile('path_file')) {
            Storage::disk('public')->delete($dokumen->path_file);

            $file = $request->file('path_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen', $filename, 'public');

            $dokumen->path_file = $path;
        }

        // Jika jenis dokumen diganti dan jenis lama 'CV', hapus CV lama jika beda dokumen baru
        if (strtolower($dokumen->jenis_dokumen) === 'cv' && strtolower($request->jenis_dokumen) !== 'cv') {
            // Tidak wajib, tapi bisa tambahkan logic jika perlu
        }

        $dokumen->jenis_dokumen = $request->jenis_dokumen;
        $dokumen->tanggal_upload = now();
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Hapus dokumen
    public function destroyDokumen($id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();
        $dokumen = Dokumen::where('id_dokumen', $id)
            ->where('id_user', $mahasiswa->id_mahasiswa)
            ->firstOrFail();

        Storage::disk('public')->delete($dokumen->path_file);
        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    // Fungsi download dokumen berdasarkan jenis, umum dan untuk CV
    public function downloadDokumen($jenis)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();

        $dokumen = Dokumen::where('id_user', $mahasiswa->id_mahasiswa)
            ->whereRaw('LOWER(jenis_dokumen) = ?', [strtolower($jenis)])
            ->latest()
            ->first();

        if (!$dokumen || !Storage::disk('public')->exists($dokumen->path_file)) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $dokumen->path_file));
    }

    public function updateAdmin(Request $request)
    {
        $user = auth()->user();
        $admin = $user->admin; // Relasi ke tabel admin

        if (!$admin) {
            abort(404, 'Data admin tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:admin,email,' . $admin->id_admin . ',id_admin',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($admin->foto_profil && Storage::exists(str_replace('/storage/', 'public/', $admin->foto_profil))) {
                Storage::delete(str_replace('/storage/', 'public/', $admin->foto_profil));
            }

            $foto = $request->file('foto_profil');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('public/foto_profil/admin', $namaFile);
            $validated['foto_profil'] = Storage::url($path);
        }

        $admin->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function updateDosen(Request $request)
    {
        $user = auth()->user();
        $dosen = $user->dosenPembimbing;

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:dosen_pembimbing,email,' . $dosen->id_dosen_pembimbing . ',id_dosen_pembimbing',
            'no_hp' => 'nullable|string|max:20',
            'bidang_minat' => 'nullable|string|max:100',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            $foto = $request->file('foto_profil');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('public/foto_profil/dosen', $namaFile);

            // Simpan path relatif
            $validated['foto_profil'] = Storage::url($path);
        }

        $dosen->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
