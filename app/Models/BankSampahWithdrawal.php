<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSampahWithdrawal extends Model
{
    protected $table = 'bank_sampah_withdrawals';

    protected $fillable = [
        'bank_sampah_id', 'amount', 'tanggal_penarikan',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tanggal_penarikan' => 'date',
    ];

    public function bankSampah()
    {
        return $this->belongsTo(BankSampah::class);
    }
}
