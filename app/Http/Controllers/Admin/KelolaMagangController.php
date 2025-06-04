<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mahasiswa;
use App\Models\Lowongan;
use App\Models\DosenPembimbing;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\ProgramStudi;
use App\Exports\LamaranExport;
use App\Exports\LamaranPdfExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KelolaMagangController extends Controller
{
    public function index(Request $request)
    {
        $prodiList = ProgramStudi::orderBy('nama_program_studi')->get();
        $dosenList = DosenPembimbing::orderBy('nama')->get();

        $query = Magang::with([
            'lamaran.mahasiswa.user',
            'lamaran.mahasiswa.programStudi',
            'lamaran.lowongan',
            'dosenPembimbing',
            'periodeMagang'
        ])->latest();

        // Filter status
        if ($request->has('status') && in_array($request->status, ['aktif', 'selesai', 'batal'])) {
            $query->where('status_magang', $request->status);
        }

        // Filter prodi
        if ($request->has('prodi') && $request->prodi != '') {
            $query->whereHas('lamaran.mahasiswa', function($q) use ($request) {
                $q->where('id_program_studi', $request->prodi);
            });
        }

        $magang = $query->get();

        // Transform data magang dengan format yang diinginkan
        $magang = $magang->map(function ($magang) {
            return [
                'id_magang' => $magang->id_magang,
                'id_lamaran' => $magang->id_lamaran,
                'id_dosen_pembimbing' => $magang->id_dosen_pembimbing,
                'id_periode' => $magang->id_periode,
                'status_magang' => $magang->status_magang,
                'path_sertifikat' => $magang->path_sertifikat,
                'created_at' => $magang->created_at,
                'updated_at' => $magang->updated_at,
                'mahasiswa' => $magang->lamaran->mahasiswa ? [
                    'id_mahasiswa' => $magang->lamaran->mahasiswa->id_mahasiswa,
                    'nim' => $magang->lamaran->mahasiswa->nim,
                    'nama' => $magang->lamaran->mahasiswa->nama,
                    'email' => $magang->lamaran->mahasiswa->user->email ?? null,
                    'no_hp' => $magang->lamaran->mahasiswa->no_hp,
                    'alamat' => $magang->lamaran->mahasiswa->alamat,
                    'jenis_kelamin' => $magang->lamaran->mahasiswa->jenis_kelamin,
                    'id_program_studi' => $magang->lamaran->mahasiswa->id_program_studi,
                    'program_studi' => $magang->lamaran->mahasiswa->programStudi->nama_program_studi ?? null,
                    'foto_profil' => $magang->lamaran->mahasiswa->foto_profil,
                    'created_at' => $magang->lamaran->mahasiswa->created_at,
                    'updated_at' => $magang->lamaran->mahasiswa->updated_at,
                ] : null,
                'lowongan' => $magang->lamaran->lowongan ? [
                    'id_lowongan' => $magang->lamaran->lowongan->id_lowongan,
                    'id_perusahaan' => $magang->lamaran->lowongan->id_perusahaan,
                    'nama_perusahaan' => $magang->lamaran->lowongan->perusahaan->nama_perusahaan,
                    'nama_posisi' => $magang->lamaran->lowongan->nama_posisi,
                ] : null,
                'lamaran' => [
                    'id_lamaran' => $magang->lamaran->id_lamaran,
                ],
                'dosen_pembimbing' => $magang->dosenPembimbing ? [
                    'id_dosen_pembimbing' => $magang->dosenPembimbing->id_dosen_pembimbing,
                    'nidn' => $magang->dosenPembimbing->nidn,
                    'nama' => $magang->dosenPembimbing->nama,
                    'email' => $magang->dosenPembimbing->email,
                    'no_hp' => $magang->dosenPembimbing->no_hp,
                    'bidang_minat' => $magang->dosenPembimbing->bidang_minat,
                    'foto_profil' => $magang->dosenPembimbing->foto_profil,
                    'created_at' => $magang->dosenPembimbing->created_at,
                    'updated_at' => $magang->dosenPembimbing->updated_at,
                ] : null,
                'periode_magang' => $magang->periodeMagang ? [
                    'id_periode' => $magang->periodeMagang->id_periode,
                    'nama_periode' => $magang->periodeMagang->nama_periode,
                    // tambahkan field periode lainnya
                ] : null,
            ];
        });

        $statistik = [
            'total'     => $magang->count(),
            'aktif'     => $magang->where('status_magang', 'aktif')->count(),
            'selesai'   => $magang->where('status_magang', 'selesai')->count(),
            'batal'     => $magang->where('status_magang', 'batal')->count(),
        ];

        return view('admin.magang.index', compact('magang', 'dosenList', 'statistik', 'prodiList'));
    }

    public function show($id, $detail)
    {
        $magang = Magang::with([
            'lamaran.mahasiswa.user',
            'lamaran.mahasiswa.programStudi',
            'lamaran.lowongan.perusahaan',
            'dosenPembimbing',
            'periodeMagang'
        ])->findOrFail($id);

        $allowed = [
            'mahasiswa' => 'admin.magang._detail_mahasiswa',
            'lowongan' => 'admin.magang._detail_lowongan',
            'magang' => 'admin.magang._detail_magang',
        ];

        if (!array_key_exists($detail, $allowed)) {
            abort(404);
        }

        $partialView = $allowed[$detail];

        if (request()->ajax()) {
            return view($partialView, compact('magang'))->render();
        }

        return view('admin.magang.show', compact('magang'));
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
        $magang = Magang::findOrFail($id);
        
        $validated = $request->validate([
            'id_dosen_pembimbing' => 'nullable|exists:dosen_pembimbing,id_dosen_pembimbing',
            'status_magang' => 'nullable|in:aktif,selesai,batal'
        ]);
        
        // If changing status
        if ($request->has('status_magang') && $request->status_magang != 'aktif') {
            $magang->update(['status_magang' => $request->status_magang]);
            return response()->json(['message' => 'Status magang berhasil diperbarui']);
        }
        
        // If assigning lecturer
        if ($request->has('id_dosen_pembimbing')) {
            $magang->update(['id_dosen_pembimbing' => $request->id_dosen_pembimbing]);
            return response()->json(['message' => 'Dosen pembimbing berhasil diperbarui']);
        }
        
        return response()->json(['message' => 'Tidak ada perubahan yang dilakukan'], 400);
    }



    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->delete();

        return redirect()->route('admin.lamaran.index')->with('success', 'Lamaran berhasil dihapus.');
    }

    public function exportExcel()
    {
        $status = request('status');
        $prodi = request('prodi');
        
        return Excel::download(new LamaranExport($status, $prodi), 'lamaran-magang.xlsx');
    }

    public function exportPdf()
    {
        $status = request('status');
        $prodi = request('prodi');
        
        $export = new LamaranPdfExport($status, $prodi);
        $pdf = PDF::loadView('exports.lamaran-pdf', $export->view()->getData());
        
        return $pdf->download('lamaran-magang.pdf');
    }
}
