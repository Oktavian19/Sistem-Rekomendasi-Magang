<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mahasiswa;
use App\Models\Lowongan;

class LamaranController extends Controller
{
    public function index()
    {
        // Tampilkan semua lamaran, lengkap dengan relasi mahasiswa dan lowongan
        $lamaran = Lamaran::with(['mahasiswa.user', 'lowongan'])->latest()->get();

        return view('admin.lamaran.index', compact('lamaran'));
    }

    public function show($id)
    {
        $lamaran = Lamaran::with(['mahasiswa.user', 'lowongan'])->findOrFail($id);

        return view('admin.lamaran.show', compact('lamaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_lamaran' => 'required|in:menunggu,diterima,ditolak',
        ]);

        $lamaran = Lamaran::findOrFail($id);
        $lamaran->status_lamaran = $request->status_lamaran;
        $lamaran->save();

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->delete();

        return redirect()->route('admin.lamaran.index')->with('success', 'Lamaran berhasil dihapus.');
    }
}
