<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaRekomendasi extends Model
{
    use HasFactory;

    protected $table = 'kriteria_rekomendasi';
    protected $primaryKey = 'id_kriteria_rekomendasi';

    protected $fillable = [
        'nama_kriteria',
        'jenis_kriteria',
    ];

        public function bobotMahasiswa()
    {
        return $this->hasMany(BobotMahasiswa::class, 'id_kriteria_rekomendasi');
    }
}
