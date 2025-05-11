<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerusahaanMitra extends Model
{
    use HasFactory;

    protected $table = 'perusahaan_mitra';
    protected $primaryKey = 'id_perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'bidang_industri',
        'alamat',
        'email',
        'telepon'
    ];
}
