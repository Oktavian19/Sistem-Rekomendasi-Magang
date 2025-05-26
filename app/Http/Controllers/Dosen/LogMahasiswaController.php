<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\DokumenLogKegiatan;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\LogKegiatan;
use App\Models\Feedback;
use Illuminate\Http\Request;


class LogMahasiswaController extends Controller
{
    /**
     * Menampilkan log kegiatan magang mahasiswa
     */
    public function show($id_mahasiswa)
    {
        // Ambil data mahasiswa
        $mahasiswa = Mahasiswa::findOrFail($id_mahasiswa);

        // Ambil data magang mahasiswa beserta relasi
        $magang = Magang::with(['lamaran.lowongan.perusahaan'])
            ->whereHas('lamaran', function ($query) use ($id_mahasiswa) {
                $query->where('id_mahasiswa', $id_mahasiswa);
            })
            ->first();

        // Jika mahasiswa memiliki data magang
        if ($magang) {
            // Ambil log kegiatan dengan pagination, dokumen, dan feedback terkait
            $logs = LogKegiatan::with(['dokumen', 'feedback.user'])
                ->where('id_magang', $magang->id_magang)
                ->orderBy('tanggal', 'desc')
                ->paginate(5);
        } else {
            $logs = collect();
        }

        return view('dosen.monitoring.log_mahasiswa', compact('mahasiswa', 'magang', 'logs'));
    }

    /**
     * Menampilkan modal untuk melihat dokumen log kegiatan
     */
    public function showDocument($id_dokumen)
    {
        $dokumen = DokumenLogKegiatan::findOrFail($id_dokumen);

        return response()->file(storage_path('app/' . $dokumen->path_file));
    }

    /**
     * Menampilkan form feedback
     */
    public function showFeedbackForm($id_log)
    {
        $log = LogKegiatan::with('magang')->findOrFail($id_log);

        return view('dosen.monitoring.feedback', compact('log'));
    }

    /**
     * Menyimpan feedback untuk log kegiatan
     */
    public function storeFeedback(Request $request, $id_log)
    {
        $request->validate([
            'komentar' => 'required|string',
            'rating' => 'nullable|integer|min=1|max=5',
        ]);

        $log = LogKegiatan::with('magang')->findOrFail($id_log);

        Feedback::create([
            'id_user' => auth()->id(),
            'id_magang' => $log->id_magang,
            'id_log' => $id_log,
            'komentar' => $request->komentar,
            'rating' => $request->rating,
            'tanggal_feedback' => now(),
        ]);

        return redirect()->route('dosen.log-mahasiswa', ['id_mahasiswa' => $log->magang->lamaran->id_mahasiswa])
            ->with('success', 'Feedback berhasil diberikan');
    }
}
