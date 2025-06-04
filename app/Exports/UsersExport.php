<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $role;

    public function __construct($role = null)
    {
        $this->role = $role;
    }

    public function collection()
    {
        $query = Users::query()->with(['mahasiswa', 'admin', 'dosenPembimbing']);
        
        if ($this->role) {
            $query->where('role', $this->role);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Username',
            'Nama',
            'Role',
            'Status'
        ];
    }

    public function map($user): array
    {
        static $i = 1;
        return [
            $i++,
            $user->username,
            $this->getNamaUser($user),
            $this->formatRole($user->role),
            $user->status ? 'Aktif' : 'Nonaktif'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            1 => ['height' => 30],
            'A:E' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    private function getNamaUser($user)
    {
        switch ($user->role) {
            case 'mahasiswa':
                return $user->mahasiswa->nama ?? '-';
            case 'admin':
                return $user->admin->nama ?? '-';
            case 'dosen_pembimbing':
                return $user->dosenPembimbing->nama ?? '-';
            default:
                return '-';
        }
    }

    private function formatRole($role)
    {
        $roles = [
            'admin' => 'Admin',
            'dosen_pembimbing' => 'Dosen Pembimbing',
            'mahasiswa' => 'Mahasiswa'
        ];
        
        return $roles[$role] ?? $role;
    }
}