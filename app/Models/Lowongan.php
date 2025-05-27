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
        'id_bidang_keahlian',
        'kuota',
        'persyaratan',
        'tanggal_buka',
        'tanggal_tutup',
        'durasi_magang'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(PerusahaanMitra::class, 'id_perusahaan', 'id_perusahaan');
    }

    // public function bidangKeahlian()
    // {
    //     return $this->belongsTo(BidangKeahlian::class, 'id_bidang_keahlian', 'id_bidang_keahlian');
    // }

    public function opsiPreferensi()
    {
        return $this->belongsTo(OpsiPreferensi::class, 'id', 'id');
    }
}
