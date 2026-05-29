<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    
    protected $fillable = [
        'user_id', 'bulan_tahun', 'nominal', 'bukti_pembayaran',
        'status', 'keterangan', 'alasan_tolak', 'tanggal_konfirmasi', 'confirmed_by'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function confirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}