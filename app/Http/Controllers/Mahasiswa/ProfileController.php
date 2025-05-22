<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Pengalaman;
use App\Models\Dokumen;
use App\Models\ProgramStudi;
use App\Models\BidangKeahlian;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $mahasiswa = Mahasiswa::with('pengalamanKerja', 'dokumen', 'programStudi', 'bidangKeahlian')
            ->where('id_mahasiswa', $userId)
            ->first();

        if (!$mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan untuk user ID: ' . $userId);
        }

        return view('mahasiswa.profile.index', compact('mahasiswa'));
    }

    public function edit()
    {
        $userId = Auth::id();
        $mahasiswa = Mahasiswa::with('pengalamanKerja', 'dokumen', 'programStudi', 'bidangKeahlian')
            ->where('id_mahasiswa', $userId)
            ->first();

        if (!$mahasiswa) {
            return response()->json(['error' => 'Data mahasiswa tidak ditemukan.'], 404);
        }
        $programStudi = ProgramStudi::all(); // ambil semua program studi
        $bidangKeahlian = BidangKeahlian::all();

        return view('mahasiswa.profile.edit_profile', compact('mahasiswa', 'programStudi', 'bidangKeahlian'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mahasiswa,email,' . Auth::id() . ',id_mahasiswa',
            'no_hp' => 'required|string|max:20',
            'id_program_studi' => 'required|exists:program_studi,id_program_studi',
            'alamat' => 'nullable|string|max:500',
            'bidang_keahlian' => 'nullable|array',
            'bidang_keahlian.*' => 'exists:bidang_keahlian,id_bidang_keahlian',
        ]);

        $mahasiswa = Mahasiswa::where('id_mahasiswa', Auth::id())->firstOrFail();

        // Update data utama
        $mahasiswa->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'id_program_studi' => $validated['id_program_studi'],
            'alamat' => $validated['alamat'] ?? null,
        ]);

        // Sync bidang keahlian
        $mahasiswa->bidangKeahlian()->sync($validated['bidang_keahlian'] ?? []);

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

    public function downloadCV()
    {
        return $this->downloadDokumen('CV');
    }
}
