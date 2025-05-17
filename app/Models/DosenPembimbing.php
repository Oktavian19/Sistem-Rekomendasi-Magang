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
        'id_dosen_pembimbing',
        'nidn',
        'nama',
        'email',
        'no_hp',
        'bidang_minat',
    ];

    public function magang()
    {
        return $this->hasMany(Magang::class, 'id_dosen_pembimbing');
    }
}
