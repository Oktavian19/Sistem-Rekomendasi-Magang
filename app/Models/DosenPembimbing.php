<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    use HasFactory;

    protected $table = 'dosen_pembimbing';
    protected $primaryKey = 'id_dosen_pembimbing';

    protected $fillable = [
        'nidn',
        'nama',
        'email',
        'no_hp',
        'bidang_minat',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_dosen_pembimbing', 'id_user');
    }
}
