@extends('layouts.app')

@section('title', 'Verifikasi Iuran - Kas RT')
@section('page-title', 'Verifikasi Pembayaran Iuran')

@section('content')
<style>
    .verification-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }
    .bukti-img {
        max-width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .btn-terima {
        background: #10b981;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        margin-right: 10px;
    }
    .btn-tolak {
        background: #ef4444;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
    }
    .info-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .info-label {
        width: 150px;
        font-weight: 600;
        color: #475569;
    }
    .info-value {
        flex: 1;
        color: #1e293b;
    }
    .badge-pending {
        background: #fed7aa;
        color: #f59e0b;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
    }
    .form-group {
        margin-top: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1e293b;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
    }
</style>

<div class="verification-card">
    <h3 style="margin-bottom: 20px;">Verifikasi Pembayaran Iuran</h3>

    <div class="info-row">
        <div class="info-label">Nama Warga:</div>
        <div class="info-value">{{ $iuran->user->name }}</div>
    </div>
    <div class="info-row">
        <div class="info-label">Bulan/Tahun:</div>
        <div class="info-value">{{ $iuran->bulan_tahun }}</div>
    </div>
    <div class="info-row">
        <div class="info-label">Nominal:</div>
        <div class="info-value">Rp {{ number_format($iuran->nominal, 0, ',', '.') }}</div>
    </div>
    <div class="info-row">
        <div class="info-label">Tanggal Bayar:</div>
        <div class="info-value">{{ $iuran->tanggal_bayar ? \Carbon\Carbon::parse($iuran->tanggal_bayar)->format('d/m/Y') : '-' }}</div>
    </div>
    <div class="info-row">
        <div class="info-label">Status:</div>
        <div class="info-value"><span class="badge-pending">⏳ Menunggu Verifikasi</span></div>
    </div>
    <div class="info-row">
        <div class="info-label">Keterangan:</div>
        <div class="info-value">{{ $iuran->keterangan ?? '-' }}</div>
    </div>

    <div style="margin: 20px 0;">
        <div class="info-label">Bukti Pembayaran:</div>
        @if($iuran->bukti_pembayaran)
            <img src="{{ asset('storage/' . $iuran->bukti_pembayaran) }}" class="bukti-img" style="margin-top: 10px;">
        @else
            <p style="color: #64748b;">Tidak ada bukti pembayaran</p>
        @endif
    </div>

    <form action="{{ route('iuran.processVerify', $iuran->id) }}" method="POST">
        @csrf
        
        <div style="display: flex; gap: 15px; margin: 20px 0;">
            <button type="submit" name="action" value="terima" class="btn-terima" onclick="return confirm('Terima pembayaran ini?')">
                <i class="fas fa-check-circle"></i> Terima & Lunaskan
            </button>
            <button type="submit" name="action" value="tolak" class="btn-tolak" onclick="return confirm('Tolak pembayaran ini?')">
                <i class="fas fa-times-circle"></i> Tolak
            </button>
        </div>

        <div id="alasan-group" style="display: none;">
            <div class="form-group">
                <label>Alasan Penolakan</label>
                <textarea name="alasan_tolak" class="form-control" rows="3" placeholder="Isi alasan penolakan..."></textarea>
            </div>
        </div>
    </form>

    <div style="margin-top: 20px;">
        <a href="{{ route('iuran.index') }}" class="btn-cancel">Kembali</a>
    </div>
</div>

<script>
    document.querySelector('button[value="tolak"]').addEventListener('click', function(e) {
        var alasanGroup = document.getElementById('alasan-group');
        if (alasanGroup.style.display === 'none') {
            e.preventDefault();
            alasanGroup.style.display = 'block';
            alert('Silakan isi alasan penolakan terlebih dahulu');
        }
    });
</script>
@endsection