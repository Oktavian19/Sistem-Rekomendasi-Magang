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
        'id_jenis_magang',
        'id_bidang_keahlian',
        'id_durasi_magang',
        'kuota',
        'persyaratan',
        'tanggal_buka',
        'tanggal_tutup',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(PerusahaanMitra::class, 'id_perusahaan', 'id_perusahaan');
    }

    // public function bidangKeahlian()
    // {
    //     return $this->belongsTo(BidangKeahlian::class, 'id_bidang_keahlian', 'id_bidang_keahlian');
    // }

    public function jenisPelaksanaan()
    {
        return $this->belongsTo(OpsiPreferensi::class, 'id_jenis_pelaksanaan');
    }

    public function bidangKeahlian()
    {
        return $this->belongsTo(OpsiPreferensi::class, 'id_bidang_keahlian');
    }

    public function durasiMagang()
    {
        return $this->belongsTo(OpsiPreferensi::class, 'id_durasi_magang');
    }

}
