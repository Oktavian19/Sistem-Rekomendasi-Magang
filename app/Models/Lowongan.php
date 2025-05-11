<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'id_lowongan';

    protected $fillable = [
        'id_perusahaan',
        'nama_posisi',
        'deskripsi',
        'kategori_keahlian',
        'kuota',
        'persyaratan',
        'tanggal_buka',
        'tanggal_tutup',
        'durasi_magang'
    ];

    public function perusahaanMitra()
    {
        return $this->belongsTo(PerusahaanMitra::class, 'id_perusahaan', 'id_perusahaan');
    }
}
