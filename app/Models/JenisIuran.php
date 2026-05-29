<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIuran extends Model
{
    protected $table = 'jenis_iurans';
    
    protected $fillable = [
        'nama', 'icon', 'nominal_default', 'denda_per_hari', 'batas_tanggal', 'status'
    ];
}