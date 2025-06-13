<?php

namespace App\Exports;

use App\Models\Lamaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LamaranDiprosesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Lamaran::whereIn('status_lamaran', ['diprosesAdmin', 'diprosesPerusahaan'])
            ->with(['mahasiswa', 'lowongan.perusahaan'])
            ->get()
            ->map(function ($item) {
                return [
                    'NIM' => $item->mahasiswa->nim,
                    'Nama Mahasiswa' => $item->mahasiswa->nama,
                    'Perusahaan' => $item->lowongan->perusahaan->nama_perusahaan,
                    'Posisi' => $item->lowongan->nama_posisi,
                    'Tanggal Lamar' => $item->tanggal_lamaran,
                    'Status' => $item->status_lamaran,
                    'Dari Rekomendasi' => $item->dari_rekomendasi ? 'Ya' : 'Tidak'
                ];
            });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Perusahaan',
            'Posisi',
            'Tanggal Lamar',
            'Status',
            'Dari Rekomendasi'
        ];
    }
}