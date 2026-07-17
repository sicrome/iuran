<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\BankSampah;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
        'nik', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
        'agama', 'status_perkawinan', 'pekerjaan', 'rt_rw', 'no_hp', 'alamat'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isBendahara()
    {
        return $this->role_id === 2;
    }

    public function isWarga()
    {
        return $this->role_id === 3;
    }

    protected static function booted()
    {
        static::updated(function ($user) {
            // Sync related bank sampah records where warga_id references this user
            BankSampah::where('warga_id', $user->id)->update([
                'nama_nasabah' => $user->name,
                'nik' => $user->nik,
                'alamat' => $user->alamat,
                'no_hp' => $user->no_hp,
            ]);
        });
    }
}