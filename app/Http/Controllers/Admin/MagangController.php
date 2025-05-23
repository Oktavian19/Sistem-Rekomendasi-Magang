<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\DosenPembimbing;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class MagangController extends Controller
{
    public function index()
    {
        // Ambil semua lamaran, lengkap dengan relasi mahasiswa dan lowongan
        $lamarans = Lamaran::with(['mahasiswa', 'lowongan'])->get();

        return view('magang.index', compact('lamarans'));
    }


    public function show($id)
    {
        $lamaran = Lamaran::with('mahasiswa')->findOrFail($id);
        $dosen = DosenPembimbing::all();
        $periodeAktif = PeriodeMagang::where('status', 'aktif')->first();

        return view('magang.show', compact('lamaran', 'dosen', 'periodeAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lamaran' => 'required|exists:lamaran,id_lamaran',
            'id_dosen_pembimbing' => 'required|exists:dosen_pembimbing,id_dosen_pembimbing',
            'id_periode' => 'required|exists:periode_magang,id_periode',
        ]);

        Magang::create([
            'id_lamaran' => $request->id_lamaran,
            'id_dosen_pembimbing' => $request->id_dosen_pembimbing,
            'id_periode' => $request->id_periode,
            'status_magang' => 'aktif',
        ]);

        return redirect()->route('magang.index')->with('success', 'Ploting berhasil dilakukan.');
    }

    public function feedback()
    {
        // Ambil semua feedback beserta relasi user (untuk tahu siapa pengirimnya) dan data magang terkait
        $feedbacks = Feedback::with(['user', 'magang.lamaran.mahasiswa'])->get();

        return view('magang.feedback', compact('feedbacks'));
    }

    public function historyMagang() {

        $userId = Auth::id();

        $lamarans = Lamaran::with('lowongan.perusahaan', 'magang')
            ->where('id_mahasiswa', $userId)
            ->latest('tanggal_lamaran')
            ->get();

        return view('mahasiswa.magang.history_magang', compact('lamarans'));
    }
}
