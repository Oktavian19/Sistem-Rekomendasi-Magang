<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magang';
    protected $primaryKey = 'id_magang';

    protected $fillable = [
        'id_lamaran',
        'id_dosen_pembimbing',
        'id_periode',
        'status_magang',
    ];

    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'id_lamaran', 'id_lamaran');
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(DosenPembimbing::class, 'id_dosen_pembimbing', 'id_dosen_pembimbing');
    }

    public function periodeMagang()
    {
        return $this->belongsTo(PeriodeMagang::class, 'id_periode', 'id_periode');
    }

    public function logKegiatan()
    {
        return $this->hasMany(LogKegiatan::class, 'id_magang', 'id_magang');
    }

    public function feedback() {
        return $this->hasMany(Feedback::class, 'id_magang', 'id_magang');
    }
}
