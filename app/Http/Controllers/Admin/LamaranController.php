<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mahasiswa;
use App\Models\Lowongan;
use App\Models\DosenPembimbing;
use App\Models\Magang;
use App\Models\PeriodeMagang;

class LamaranController extends Controller
{
    public function index(Request $request)
    {
        // Tampilkan semua lamaran, lengkap dengan relasi mahasiswa dan lowongan
        $lamaran = Lamaran::with(['mahasiswa.user', 'lowongan', 'magang.dosenPembimbing'])->latest()->get();

        // Ambil data dosen untuk dropdown
        $dosenList = DosenPembimbing::orderBy('nama')->get();

        // Filter setiap status lamaran
        $query = Lamaran::with(['mahasiswa.user', 'lowongan', 'magang.dosenPembimbing'])->latest();
        if ($request->has('status') && in_array($request->status, ['diterima', 'menunggu', 'ditolak'])) {
            $query->where('status_lamaran', $request->status);
        }

        $lamaran = $query->get();

        // Tambahkan statistik lamaran
        $statistik = [
            'total'     => Lamaran::count(),
            'diterima'  => Lamaran::where('status_lamaran', 'diterima')->count(),
            'menunggu'  => Lamaran::where('status_lamaran', 'menunggu')->count(),
            'ditolak'   => Lamaran::where('status_lamaran', 'ditolak')->count(),
        ];

        return view('admin.lamaran.index', compact('lamaran', 'dosenList', 'statistik'));
    }

    public function show($id, $detail)
    {
        $lamaran = Lamaran::with([
            'mahasiswa.user',
            'mahasiswa.programStudi',
            'lowongan.perusahaan',
        ])->findOrFail($id);

        $allowed = [
            'mahasiswa'  => 'admin.lamaran._detail_mahasiswa',
            'lowongan'   => 'admin.lamaran._detail_lowongan',
            'lamaran'     => 'admin.lamaran._detail_lamaran',
        ];

        if (! array_key_exists($detail, $allowed)) {
            abort(404);
        }
        $partialView = $allowed[$detail];

        if (request()->ajax()) {
            return view($partialView, compact('lamaran'))->render();
        }

        return view('admin.lamaran.show', compact('lamaran'));
    }

    public function downloadDokumen($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $path = storage_path('app/public/' . $dokumen->path_file);
        
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_lamaran' => 'required|in:menunggu,diterima,ditolak',
            'id_dosen_pembimbing' => 'nullable|exists:dosen_pembimbing,id_dosen_pembimbing',
        ]);

        $lamaran = Lamaran::findOrFail($id);
        $lamaran->status_lamaran = $request->status_lamaran;
        $lamaran->save();

        // Jika status diterima, atur magang dan dosen
        if ($request->status_lamaran === 'diterima') {
            $existingMagang = Magang::where('id_lamaran', $lamaran->id_lamaran)->first();

            if (!$existingMagang) {
                $periodeAktif = PeriodeMagang::where('status', 'aktif')->first();
                Magang::create([
                    'id_lamaran' => $lamaran->id_lamaran,
                    'status_magang' => 'aktif',
                    'id_periode' => $periodeAktif?->id_periode,
                    'id_dosen_pembimbing' => $request->id_dosen_pembimbing,
                ]);
            } else if ($request->id_dosen_pembimbing) {
                $existingMagang->update([
                    'id_dosen_pembimbing' => $request->id_dosen_pembimbing
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Status lamaran berhasil diperbarui.',
            ]);
        }

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->delete();

        return redirect()->route('admin.lamaran.index')->with('success', 'Lamaran berhasil dihapus.');
    }
}
