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
        ]);

        $log = LogKegiatan::with('magang')->findOrFail($id_log);

        Feedback::create([
            'id_user' => auth()->id(),
            'id_magang' => $log->id_magang,
            'id_log' => $id_log,
            'komentar' => $request->komentar,
            'tanggal_feedback' => now(),
        ]);

        return redirect('/mahasiswa/' . $log->magang->lamaran->id_mahasiswa . '/logs')
            ->with('success', 'Feedback berhasil diberikan');
    }

    public function modal($id)
    {
        $magang = Magang::with('lamaran.lowongan.perusahaan')->find($id);

        return view('mahasiswa.magang.feedback_form', compact('magang'));
    }


    public function storeFeedbackMahasiswa(Request $request)
    {
        // Validasi input
        $request->validate([
            'komentar' => 'required|string',
        ]);

        // Simpan feedback baru
        Feedback::create([
            'id_user' => auth()->id(),
            'id_magang' => $request->id_magang,
            'komentar' => $request->komentar,
            'tanggal_feedback' => now(),
        ]);

        // Redirect ke halaman log dengan pesan sukses
        return back()->with('success', 'Feedback berhasil dikirim.');
    }
}
