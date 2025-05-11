<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMagang extends Model
{
    use HasFactory;

    protected $table = 'jenis_magang';
    protected $primaryKey = 'id_jenis_magang';
    
    protected $fillable = [
        'nama_jenis_magang',
    ];

        public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'mahasiswa_jenis_magang',
            'id_jenis_magang',
            'id_mahasiswa'
        )->withTimestamps();
    }
}
