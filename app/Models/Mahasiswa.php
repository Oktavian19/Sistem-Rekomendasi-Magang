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
        'nim',
        'nama',
        'email',
        'no_hp',
        'id_program_studi',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id_program_studi');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_mahasiswa', 'id_user');
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

        public function preferensiLokasi()
    {
        return $this->belongsToMany(
            PreferensiLokasi::class,
            'mahasiswa_preferensi_lokasi',
            'id_mahasiswa',
            'id_preferensi_lokasi'
        )->withTimestamps();
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
}
