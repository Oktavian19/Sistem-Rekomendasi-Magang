<?php

namespace App\Exports;

use App\Models\Magang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaMagangAktifExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Magang::where('status_magang', 'aktif')
            ->with([
                'lamaran.mahasiswa',
                'lamaran.lowongan.perusahaan',
                'dosenPembimbing',
                'lamaran.lowongan.jenisPelaksanaan',
                'lamaran.lowongan.durasiMagang'
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'NIM' => $item->lamaran->mahasiswa->nim,
                    'Nama Mahasiswa' => $item->lamaran->mahasiswa->nama,
                    'Perusahaan' => $item->lamaran->lowongan->perusahaan->nama_perusahaan,
                    'Posisi' => $item->lamaran->lowongan->nama_posisi,
                    'Jenis Pelaksanaan' => $item->lamaran->lowongan->jenisPelaksanaan->label ?? '-',
                    'Durasi Magang' => $item->lamaran->lowongan->durasiMagang->label ?? '-',
                    'Dosen Pembimbing' => $item->dosenPembimbing->nama ?? '-',
                    'Status Magang' => $item->status_magang
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
            'Jenis Pelaksanaan',
            'Durasi Magang',
            'Dosen Pembimbing',
            'Status Magang'
        ];
    }
}