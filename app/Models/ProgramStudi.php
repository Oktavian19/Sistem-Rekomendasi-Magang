<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi';
    protected $primaryKey = 'id_program_studi';

    protected $fillable = [
        'kode_program_studi',
        'nama_program_studi',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_program_studi');
    }
}
