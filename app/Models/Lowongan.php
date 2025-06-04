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
        'id_jenis_pelaksanaan',
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

    public function jenisPelaksanaan()
    {
        return $this->belongsTo(OpsiPreferensi::class, 'id_jenis_pelaksanaan');
    }

    public function durasiMagang()
    {
        return $this->belongsTo(OpsiPreferensi::class, 'id_durasi_magang');
    }

    // Ini digunakan untuk sync (jangan ada whereHas!)
    public function semuaPreferensi()
    {
        return $this->belongsToMany(OpsiPreferensi::class, 'preferensi_lowongan', 'id_lowongan', 'id_opsi');
    }

    // Ini untuk ambil bidang keahlian yang difilter oleh kategori
    public function bidangKeahlian()
    {
        return $this->semuaPreferensi()->whereHas('kategori', function ($q) {
            $q->where('kode', 'bidang_keahlian');
        });
    }

    // Sama untuk fasilitas
    public function fasilitas()
    {
        return $this->semuaPreferensi()->whereHas('kategori', function ($q) {
            $q->where('kode', 'fasilitas');
        });
    }
}
