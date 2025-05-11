<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiLokasi extends Model
{
    use HasFactory;

    protected $table = 'preferensi_lokasi';
    protected $primaryKey = 'id_preferensi_lokasi';

    protected $fillable = [
        'nama_lokasi',
    ];

      public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'mahasiswa_preferensi_lokasi',
            'id_preferensi_lokasi',
            'id_mahasiswa'
        )->withTimestamps();
    }
}
