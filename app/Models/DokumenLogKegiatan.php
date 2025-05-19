<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenLogKegiatan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_log_kegiatan';
    protected $primaryKey = 'id_dokumen_log_kegiatan';

    protected $fillable = [
        'id_log',
        'path_file',
    ];

    /**
     * Relasi ke tabel log_kegiatan
     */
    public function logKegiatan()
    {
        return $this->belongsTo(LogKegiatan::class, 'id_log', 'id_log');
    }
}
