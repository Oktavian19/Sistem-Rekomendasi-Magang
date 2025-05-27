<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPreferensi extends Model
{
    use HasFactory;

    protected $table = 'kategori_preferensi';
    
    protected $fillable = [
        'kode',
        'nama'
    ];

    public $timestamps = false;

    public function opsi_preferensi() {
        return $this->hasMany(OpsiPreferensi::class,'id_kategori');
    }
}
