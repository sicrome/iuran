<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusRt extends Model
{
    protected $table = 'pengurus_rt';
    protected $fillable = ['nama', 'jabatan', 'no_telepon', 'alamat', 'foto', 'masa_jabatan_mulai', 'masa_jabatan_selesai', 'status'];
}