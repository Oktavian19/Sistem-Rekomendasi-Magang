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
        'id_program_studi',
        'foto_profil',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id_program_studi');
    }

    public function opsiPreferensi()
    {
        return $this->belongsToMany(
            OpsiPreferensi::class,           // Model target
            'preferensi_pengguna',           // Nama tabel pivot
            'id_mahasiswa',                  // FK di pivot untuk mahasiswa
            'id_opsi'                        // FK di pivot untuk bidang keahlian
        )->withPivot('ranking', 'poin')->withTimestamps();                 // Jika perlu akses timestamps
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

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}
