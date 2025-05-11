<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeMagang extends Model
{
    use HasFactory;

    protected $table = 'periode_magang';
    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
}
