<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = "lamaran";
    protected $primaryKey = "id_lamaran";

    protected $fillable = [
        'id_mahasiswa',
        'id_lowongan',
        'tanggal_lamaran',
        'status_lamaran',
        'dari_rekomendasi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'id_lowongan', 'id_lowongan');
    }

    public function magang()
    {
        return $this->hasOne(Magang::class, 'id_lamaran');
    }
}
