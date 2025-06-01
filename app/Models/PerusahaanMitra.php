<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'telepon',
        'path_logo'
    ];

    public function lowongan(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
