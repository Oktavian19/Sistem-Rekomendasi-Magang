<?php

namespace App\Exports;

use App\Models\Magang;

class MagangPdfExport
{
    protected $status;
    protected $prodi;

    public function __construct($status = null, $prodi = null)
    {
        $this->status = $status;
        $this->prodi = $prodi;
    }

    public function collection()
    {
        $query = Magang::with([
            'lamaran.mahasiswa.programStudi',
            'lamaran.lowongan.perusahaan',
            'dosenPembimbing'
        ]);

        if ($this->status) {
            $query->where('status_magang', $this->status);
        }

        if ($this->prodi) {
            $query->whereHas('lamaran.mahasiswa', function($q) {
                $q->where('id_program_studi', $this->prodi);
            });
        }

        return $query->get();
    }
}