<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogKegiatan extends Model
{
    use HasFactory;

    protected $table = 'log_kegiatan';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_magang',
        'tanggal',
        'deskripsi_kegiatan',
        'minggu'
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'id_magang', 'id_magang');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenLogKegiatan::class, 'id_log', 'id_log');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'id_log', 'id_log');
    }
}
