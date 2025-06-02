<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{KategoriPreferensi, OpsiPreferensi};
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelolaInputController extends Controller
{
    public function input_fasilitas()
    {
        $fasilitas = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'fasilitas');
        })->get();

        return view('admin.input_fasilitas.index', compact('fasilitas'));
    }

    public function store_fasilitas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        // Generate kode otomatis dari nama
        $kode = strtolower(preg_replace('/[^A-Za-z0-9]/', '_', $request->nama));
        
        // Find or create the kategori
        $kategori = KategoriPreferensi::firstOrCreate(
            ['kode' => 'fasilitas'],
            ['nama' => 'Fasilitas']
        );

        // Create new fasilitas
        $fasilitas = OpsiPreferensi::create([
            'kode' => $kode,
            'label' => $request->nama,
            'id_kategori' => $kategori->id
        ]);

        return response()->json([
            'success' => true,
            'fasilitas' => [
                'id' => $fasilitas->id,
                'nama' => $fasilitas->label,
                'kode' => $fasilitas->kode
            ]
        ]);
    }

    public function destroy_fasilitas($id)
    {
        $fasilitas = OpsiPreferensi::findOrFail($id);
        $fasilitas->delete();

        return response()->json(['success' => true]);
    }

    public function input_bidang_keahlian()
    {
        $bidangKeahlian = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'bidang_keahlian');
        })->get();

        return view('admin.input_bidang_keahlian.index', compact('bidangKeahlian'));
    }

    public function store_bidang_keahlian(Request $request)
    {
        $request->validate([
            'kode' => [
                'required',
                'string',
            ],
            'nama' => 'required|string|max:255'
        ]);

        // Find or create the kategori
        $kategori = KategoriPreferensi::firstOrCreate(
            ['kode' => 'bidang_keahlian'],  // Changed from 'fasilitas' to match your context
            ['nama' => 'Bidang Keahlian']
        );

        // Create new bidang keahlian
        $bidangKeahlian = OpsiPreferensi::create([
            'kode' => $request->kode,
            'label' => $request->nama,
            'id_kategori' => $kategori->id  // Explicitly set the foreign key
        ]);

        return response()->json([
            'success' => true,
            'fasilitas' => [
                'id' => $bidangKeahlian->id,
                'nama' => $bidangKeahlian->label
            ]
        ]);
    }

    public function destroy_bidang_keahlian($id)
    {
        $bidangKeahlian = OpsiPreferensi::findOrFail($id);
        $bidangKeahlian->delete();

        return response()->json(['success' => true]);
    }

    public function input_jenis_perusahaan()
    {
        $jenisPerusahaan = OpsiPreferensi::whereHas('kategori', function ($query) {
            $query->where('kode', 'jenis_perusahaan');
        })->get();

        return view('admin.input_jenis_perusahaan.index', compact('jenisPerusahaan'));
    }

    public function store_jenis_perusahaan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        // Generate kode otomatis dari nama
        $kode = strtolower(preg_replace('/[^A-Za-z0-9]/', '_', $request->nama));
        
        // Find or create the kategori
        $kategori = KategoriPreferensi::firstOrCreate(
            ['kode' => 'jenis_perusahaan'],
            ['nama' => 'Jenis Perusahaan']
        );

        // Create new jenis perusahaan
        $jenisPerusahaan = OpsiPreferensi::create([
            'kode' => $kode,
            'label' => $request->nama,
            'id_kategori' => $kategori->id
        ]);

        return response()->json([
            'success' => true,
            'jenis' => [
                'id' => $jenisPerusahaan->id,
                'nama' => $jenisPerusahaan->label
            ]
        ]);
    }
}