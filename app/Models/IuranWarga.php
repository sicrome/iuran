<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IuranWarga extends Model
{
    protected $table = 'iuran_wargas';
    
    protected $fillable = [
        'user_id', 'bulan_tahun', 'nominal', 'status', 'tanggal_bayar',
        'verifikasi_status', 'alasan_tolak', 'bukti_pembayaran', 
        'tanggal_verifikasi', 'diverifikasi_oleh'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}