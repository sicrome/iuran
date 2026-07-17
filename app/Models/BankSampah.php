<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSampah extends Model
{
    protected $fillable = [
        'kode_nasabah', 'nama_nasabah', 'nik', 'alamat', 'no_hp',
        'jenis_sampah', 'berat_sampah', 'harga_per_kg', 'saldo_tabungan', 'status',
        'petugas', 'keterangan', 'tanggal_setoran',
    ];

    protected $casts = [
        'berat_sampah' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'saldo_tabungan' => 'decimal:2',
        'tanggal_setoran' => 'date',
    ];

    public function withdrawals()
    {
        return $this->hasMany(BankSampahWithdrawal::class);
    }
}
