<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRt extends Model
{
    protected $table = 'data_rt';
    protected $fillable = ['nama_rt', 'kode_pos', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'logo', 'email', 'no_telepon', 'alamat_lengkap'];
}