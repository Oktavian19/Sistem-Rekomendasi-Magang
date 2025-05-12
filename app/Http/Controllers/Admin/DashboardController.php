<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\DosenPembimbing;
use App\Models\Feedback;
use App\Models\Magang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswaMagang = Magang::distinct('id_mahasiswa')->count();
        $trenBidangMinat = Mahasiswa::select('bidang_minat', DB::raw('count(*) as total'))
            ->groupBy('bidang_minat')
            ->get();
        $totalDosenPembimbing = DosenPembimbing::count();
        $rasioDosenMahasiswa = $totalMahasiswaMagang / max($totalDosenPembimbing, 1);

        // Asumsi: kamu punya evaluasi efektivitas (misalnya via feedback)
        $efektivitas = Feedback::avg('skor');

        return view('dashboard.index', compact(
            'totalMahasiswaMagang',
            'trenBidangMinat',
            'totalDosenPembimbing',
            'rasioDosenMahasiswa',
            'efektivitas'
        ));
    }
}
