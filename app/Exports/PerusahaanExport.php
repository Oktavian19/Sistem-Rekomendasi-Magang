<?php

namespace App\Exports;

use App\Models\PerusahaanMitra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class PerusahaanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $bidangIndustri;

    public function __construct($bidangIndustri = null)
    {
        $this->bidangIndustri = $bidangIndustri;
    }


    public function collection()
    {
        $query = PerusahaanMitra::with('jenisPerusahaan');
        
        if ($this->bidangIndustri) {
            $query->where('bidang_industri', $this->bidangIndustri);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Perusahaan',
            'Alamat',
            'Jenis Perusahaan', 
            'Bidang Industri',
            'Nomor Telepon',
            'Email',
        ];
    }

    public function map($perusahaan): array
    {
        static $i = 1;
        return [
            $i++,
            $perusahaan->nama_perusahaan,
            $perusahaan->alamat,
            $perusahaan->jenisPerusahaan ? $perusahaan->jenisPerusahaan->label : '-',
            $perusahaan->bidang_industri,
            $perusahaan->telepon,
            $perusahaan->email,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Set header row height
            1 => ['height' => 30],
            
            // Set alignment for all cells
            'A:H' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}