<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatusLamaranExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Lowongan',
            'Perusahaan',
            'Tanggal Lamar',
            'Status',
            'Rekomendasi'
        ];
    }
}