<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'bobot_mahasiswa';
    protected $primaryKey = 'id_bobot_mahasiswa';
    
    protected $fillable = [
        'id_mahasiswa',
        'id_kriteria_rekomendasi',
        'nilai_bobot',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    // Relasi ke kriteria rekomendasi
    public function kriteriaRekomendasi()
    {
        return $this->belongsTo(KriteriaRekomendasi::class, 'id_kriteria_rekomendasi');
    }
}
