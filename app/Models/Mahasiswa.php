<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';


    protected $fillable = [
        'id_mahasiswa',
        'nim',
        'nama',
        'email',
        'alamat',
        'no_hp',
        'preferensi_lokasi',
        'latitude',
        'longitude',
        'id_program_studi',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id_program_studi');
    }

    public function bidangKeahlian()
    {
        return $this->belongsToMany(
            BidangKeahlian::class,           // Model target
            'mahasiswa_bidang_keahlian',     // Nama tabel pivot
            'id_mahasiswa',                  // FK di pivot untuk mahasiswa
            'id_bidang_keahlian'             // FK di pivot untuk bidang keahlian
        )->withTimestamps();                 // Jika perlu akses timestamps
    }

    public function jenisMagang()
    {
        return $this->belongsToMany(
            JenisMagang::class,
            'mahasiswa_jenis_magang',
            'id_mahasiswa',
            'id_jenis_magang'
        )->withTimestamps();
    }

    public function bobotKriteria()
    {
        return $this->hasMany(BobotMahasiswa::class, 'id_mahasiswa');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_mahasiswa', 'id_user');
    }

    public function pengalamanKerja()
    {
        return $this->hasMany(Pengalaman::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'id_user', 'id_mahasiswa');
    }

    // User.php
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id', 'id');
    }

    // Mahasiswa.php
    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    // Lamaran.php
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'id_lowongan', 'id_lowongan');
    }

    // Lowongan.php
    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang', 'id_magang');
    }
}
