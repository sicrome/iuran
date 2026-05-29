<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
    'name', 'email', 'password', 'role_id',
    'nik', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
    'agama', 'status_perkawinan', 'pekerjaan', 'rt_rw', 'no_hp', 'alamat'
];
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}