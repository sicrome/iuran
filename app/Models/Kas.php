<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kas extends Model
{
    protected $table = 'kas';
    
    protected $fillable = [
        'user_id', 'bulan', 'jenis', 'nominal', 'tanggal', 'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}