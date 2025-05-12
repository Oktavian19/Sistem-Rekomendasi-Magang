<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKeahlian extends Model
{
    use HasFactory;

    protected $table = 'bidang_keahlian';
    protected $primaryKey = 'id_bidang_keahlian';
    
    protected $fillable = [
        'nama_bidang',
    ];

        public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'mahasiswa_bidang_keahlian',
            'id_bidang_keahlian',
            'id_mahasiswa'
        )->withTimestamps();
    }
}
