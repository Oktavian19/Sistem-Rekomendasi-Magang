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
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ApplicationStatusNotification;
use Illuminate\Support\Facades\Mail;

class LamaranController extends Controller
{
    public function index(Request $request)
    {
        $prodiList = ProgramStudi::orderBy('nama_program_studi')->get();

        $dosenList = DosenPembimbing::orderBy('nama')->get();

        $query = Lamaran::with([
            'mahasiswa.user',
            'mahasiswa.programStudi',
            'lowongan',
            'magang.dosenPembimbing'
        ])->latest();

        if ($request->has('status') && in_array($request->status, ['diprosesAdmin', 'diprosesPerusahaan', 'diterima', 'ditolak'])) {
            $query->where('status_lamaran', $request->status);
        }

        if ($request->has('prodi') && $request->prodi != '') {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('id_program_studi', $request->prodi);
            });
        }

        $lamaran = $query->get();

        $statistik = [
            'total'     => $query->count(),
            'diterima'  => $query->where('status_lamaran', 'diterima')->count(),
            'diprosesAdmin' => $query->where('status_lamaran', 'diprosesAdmin')->count(),
            'diprosesPerusahaan' => $query->where('status_lamaran', 'diprosesPerusahaan')->count(),
            'ditolak'   => $query->where('status_lamaran', 'ditolak')->count(),
        ];

        return view('admin.lamaran.index', compact('lamaran', 'dosenList', 'statistik', 'prodiList'));
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
            'status_lamaran' => 'required|in:diprosesAdmin,diprosesPerusahaan,diterima,ditolak',
        ]);

        $lamaran = Lamaran::with(['mahasiswa', 'lowongan.perusahaan'])->findOrFail($id);
        $previousStatus = $lamaran->status_lamaran;
        $lamaran->status_lamaran = $request->status_lamaran;
        $lamaran->save();

        // Send email notification if status changed to diterima or ditolak
        if (($request->status_lamaran === 'diterima' || $request->status_lamaran === 'ditolak') && 
            $previousStatus !== $request->status_lamaran) {
            
            try {
                Mail::to($lamaran->mahasiswa->email)
                    ->send(new ApplicationStatusNotification($lamaran, $request->status_lamaran));
            } catch (\Exception $e) {
                \Log::error('Failed to send email notification: ' . $e->getMessage());
                
                return $request->ajax()
                ? response()->json(['status' => false, 'message' => $e->getMessage()], 500)
                : redirect()->back()->with('error', $e->getMessage());

            }
        }

        // Jika status diterima dan belum ada magang, buat data magang dengan dosen null
        if ($request->status_lamaran === 'diterima') {
            $existingMagang = Magang::where('id_lamaran', $lamaran->id_lamaran)->first();

            if (!$existingMagang) {
                $periodeAktif = PeriodeMagang::where('status', 'aktif')->first();

                Magang::create([
                    'id_lamaran' => $lamaran->id_lamaran,
                    'status_magang' => 'aktif',
                    'id_periode' => $periodeAktif?->id_periode,
                    'id_dosen_pembimbing' => null,
                ]);
            }
        }

        return $request->ajax()
            ? response()->json(['status' => true, 'message' => 'Status lamaran berhasil diperbarui.'])
            : redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
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
