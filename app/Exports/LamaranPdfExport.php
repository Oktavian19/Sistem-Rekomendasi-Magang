<?php

namespace App\Exports;

use App\Models\Lamaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LamaranPdfExport implements FromView
{
    protected $filterStatus;
    protected $filterProdi;

    public function __construct($status = null, $prodi = null)
    {
        $this->filterStatus = $status;
        $this->filterProdi = $prodi;
    }

    public function view(): View
    {
        $query = Lamaran::with(['mahasiswa', 'lowongan.perusahaan', 'magang.dosenPembimbing'])
            ->orderBy('created_at', 'desc');

        if ($this->filterStatus) {
            $query->where('status_lamaran', $this->filterStatus);
        }

        if ($this->filterProdi) {
            $query->whereHas('mahasiswa', function($q) {
                $q->where('id_program_studi', $this->filterProdi);
            });
        }

        $lamaran = $query->get();

        return view('exports.lamaran-pdf', [
            'lamaran' => $lamaran,
            'filterStatus' => $this->filterStatus,
            'filterProdi' => $this->filterProdi
        ]);
    }
}