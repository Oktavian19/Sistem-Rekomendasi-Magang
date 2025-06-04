<?php

namespace App\Exports;

use App\Models\Lamaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LamaranExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filterStatus;
    protected $filterProdi;

    public function __construct($status = null, $prodi = null)
    {
        $this->filterStatus = $status;
        $this->filterProdi = $prodi;
    }

    public function collection()
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

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Lowongan',
            'Perusahaan',
            'Status',
        ];
    }

    public function map($lamaran): array
    {
        return [
            $lamaran->mahasiswa->nim,
            $lamaran->mahasiswa->nama,
            $lamaran->lowongan->nama_posisi,
            $lamaran->lowongan->perusahaan->nama_perusahaan,
            ucfirst($lamaran->status_lamaran),
        ];
    }
}