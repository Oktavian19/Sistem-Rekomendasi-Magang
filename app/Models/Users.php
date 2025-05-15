<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ========================
    // Relasi
    // ========================

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_mahasiswa', 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_admin', 'id_user');
    }

    public function dosenPembimbing()
    {
        return $this->hasOne(DosenPembimbing::class, 'id_dosen_pembimbing', 'id_user');
    }

    // ========================
    // Helper role
    // ========================

    public function getRole(): string
    {
        return $this->role;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    // ========================
    // Auto delete relasi saat user dihapus
    // ========================

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->role === 'mahasiswa' && $user->mahasiswa) {
                $user->mahasiswa->delete();
            }

            if ($user->role === 'admin' && $user->admin) {
                $user->admin->delete();
            }

            if ($user->role === 'dosen_pembimbing' && $user->dosenPembimbing) {
                $user->dosenPembimbing->delete();
            }
        });
    }
}
