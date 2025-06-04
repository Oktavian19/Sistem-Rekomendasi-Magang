<?php

namespace App\Exports;

use App\Models\Magang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MagangExport implements FromCollection, WithHeadings, WithMapping
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

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Program Studi',
            'Lowongan',
            'Perusahaan',
            'Status Magang',
            'Dosen Pembimbing'
        ];
    }

    public function map($magang): array
    {
        return [
            $magang->lamaran->mahasiswa->nama,
            $magang->lamaran->mahasiswa->nim,
            $magang->lamaran->mahasiswa->programStudi->nama_program_studi,
            $magang->lamaran->lowongan->nama_posisi,
            $magang->lamaran->lowongan->perusahaan->nama_perusahaan,
            ucfirst($magang->status_magang),
            $magang->dosenPembimbing ? $magang->dosenPembimbing->nama : '-'
        ];
    }
}