<?php

namespace App\Exports;

use App\Models\Lowongan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LowonganExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $nama_posisi;
    protected $jenis_pelaksanaan;

    public function __construct($nama_posisi = null, $jenis_pelaksanaan = null)
    {
        $this->nama_posisi = $nama_posisi;
        $this->jenis_pelaksanaan = $jenis_pelaksanaan;
    }

    public function collection()
    {
        $query = Lowongan::with(['perusahaan', 'jenisPelaksanaan', 'durasiMagang']);
        
        if ($this->nama_posisi) {
            $query->where('nama_posisi', $this->nama_posisi);
        }
        
        if ($this->jenis_pelaksanaan) {
            $query->whereHas('jenisPelaksanaan', function($q) {
                $q->where('label', $this->jenis_pelaksanaan);
            });
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Perusahaan',
            'Posisi',
            'Jenis Pelaksanaan',
            'Durasi Magang',
            'Kuota',
            'Tanggal Buka',
            'Tanggal Tutup'
        ];
    }

    public function map($lowongan): array
    {
        static $i = 1;
        return [
            $i++,
            $lowongan->perusahaan->nama_perusahaan ?? '-',
            $lowongan->nama_posisi,
            $lowongan->jenisPelaksanaan->label ?? '-',
            $lowongan->durasiMagang->label ?? '-',
            $lowongan->kuota,
            $lowongan->tanggal_buka ? date('d/m/Y', strtotime($lowongan->tanggal_buka)) : '-',
            $lowongan->tanggal_tutup ? date('d/m/Y', strtotime($lowongan->tanggal_tutup)) : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            1 => ['height' => 30],
            'A:H' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}