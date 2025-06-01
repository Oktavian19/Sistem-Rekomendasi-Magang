<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiPreferensi extends Model
{
    use HasFactory;

    protected $table = 'opsi_preferensi';
    
    protected $fillable = [
        'id_kategori',
        'kode',
        'label'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPreferensi::class, 'id_kategori');
    }

    public function mahasiswa() {
        return $this->belongsToMany(
            Mahasiswa::class,
            'preferensi_pengguna',
            'id_opsi',
            'id_mahasiswa'
        )->withPivot('ranking', 'poin')->withTimestamps();
    }
}
