<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mahasiswa;
use App\Models\Lowongan;
use App\Models\DosenPembimbing; 
use App\Models\Magang; 

class LamaranController extends Controller
{
    public function index()
    {
        // Tampilkan semua lamaran, lengkap dengan relasi mahasiswa dan lowongan
        $lamaran = Lamaran::with(['mahasiswa.user', 'lowongan'])->latest()->get();
        
        // Ambil data dosen untuk dropdown
        $dosenList = DosenPembimbing::orderBy('nama')->get();

        return view('admin.lamaran.index', compact('lamaran', 'dosenList'));
    }

    public function show($id)
    {
        $lamaran = Lamaran::with([
            'mahasiswa.user',
            'mahasiswa.programStudi',
            'lowongan.perusahaan',
        ])->findOrFail($id);

        if(request()->ajax()) {
            return view('admin.lamaran._detail', compact('lamaran'))->render();
        }

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

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Status lamaran berhasil diperbarui.'
            ]);
        }    

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function updateDosen(Request $request, $id)
    {
        Magang::where('id_lamaran', $id)->update([
            'id_dosen_pembimbing' => $request->dosen_pembimbing,
        ]);        

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Dosen pembimbing berhasil diperbarui.'
            ]);
        }

        return redirect()->back()->with('success', 'Dosen pembimbing berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->delete();

        return redirect()->route('admin.lamaran.index')->with('success', 'Lamaran berhasil dihapus.');
    }
}