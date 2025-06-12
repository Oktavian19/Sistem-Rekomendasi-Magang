<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\DosenPembimbing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RasioDosenMahasiswaExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Mahasiswa' => new MahasiswaSheet(),
            'Dosen Pembimbing' => new DosenSheet()
        ];
    }
}

class MahasiswaSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Mahasiswa::with('programStudi')->get()->map(function ($item) {
            return [
                'NIM' => $item->nim,
                'Nama' => $item->nama,
                'Program Studi' => $item->programStudi->nama_program_studi ?? '-',
                'Email' => $item->email,
                'No. HP' => $item->no_hp,
                'Alamat' => $item->alamat
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Program Studi',
            'Email',
            'No. HP',
            'Alamat'
        ];
    }
}

class DosenSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DosenPembimbing::all()->map(function ($item) {
            return [
                'NIDN' => $item->nidn,
                'Nama' => $item->nama,
                'Email' => $item->email,
                'No. HP' => $item->no_hp,
                'Bidang Minat' => $item->bidang_minat
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIDN',
            'Nama',
            'Email',
            'No. HP',
            'Bidang Minat'
        ];
    }
}