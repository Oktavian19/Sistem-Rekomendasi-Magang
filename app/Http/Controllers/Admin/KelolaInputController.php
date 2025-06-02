<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{KategoriPreferensi, OpsiPreferensi};
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
            'kode' => 'required|string',
            'nama' => 'required|string|max:255'
        ]);

        $kategori = KategoriPreferensi::firstOrCreate(
            ['kode' => 'fasilitas'],
            ['nama' => 'Fasilitas']
        );

        $fasilitas = new OpsiPreferensi();
        $fasilitas->kode = $request->kode;
        $fasilitas->nama = $request->nama;
        $fasilitas->kategori()->associate($kategori);
        $fasilitas->save();

        return response()->json([
            'success' => true,
            'fasilitas' => [
                'id' => $fasilitas->id,
                'nama' => $fasilitas->nama
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
            'kode' => 'required|string',
            'nama' => 'required|string|max:255'
        ]);

        $kategori = KategoriPreferensi::firstOrCreate(
            ['kode' => 'fasilitas'],
            ['nama' => 'Fasilitas']
        );

        $bidangKeahlian = new OpsiPreferensi();
        $bidangKeahlian->kode = $request->kode;
        $bidangKeahlian->nama = $request->nama;
        $bidangKeahlian->kategori()->associate($kategori);
        $bidangKeahlian->save();

        return response()->json([
            'success' => true,
            'fasilitas' => [
                'id' => $bidangKeahlian->id,
                'nama' => $bidangKeahlian->nama
            ]
        ]);
    }

    public function destroy_bidang_keahlian($id)
    {
        $bidangKeahlian = OpsiPreferensi::findOrFail($id);
        $bidangKeahlian->delete();

        return response()->json(['success' => true]);
    }
}