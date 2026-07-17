@extends('layouts.app')

@section('title', 'Layanan - Kas RT')
@section('page-title', 'Layanan')

@section('content')
<style>
    .layanan-shell { display: grid; gap: 22px; }
    .layanan-hero {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 45%, #e0f2fe 100%);
        border-radius: 24px;
        padding: 28px 32px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(59, 130, 246, 0.12);
    }
    .layanan-hero h2 { font-size: 28px; font-weight: 800; margin-bottom: 10px; color: #0f172a; }
    .layanan-hero p { font-size: 14px; color: #334155; line-height: 1.75; max-width: 760px; }
    .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; }
    .service-card {
        background: white;
        border-radius: 22px;
        padding: 22px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        display: grid;
        gap: 16px;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .service-card:hover {
        transform: translateY(-3px);
        border-color: #3b82f6;
    }
    .service-card .service-title { font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
    .service-card .service-desc { font-size: 13px; color: #475569; line-height: 1.7; }
    .service-card .service-meta { display: flex; justify-content: space-between; gap: 8px; align-items: center; }
    .service-card .service-icon { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; background: #eff6ff; color: #2563eb; font-size: 20px; }
    .service-card .service-image { width: 64px; height: 64px; border-radius: 12px; object-fit: cover; background: #f8fafc; border: 1px solid #e6eef6; padding: 8px; }
    .service-card .badge { font-size: 12px; font-weight: 700; color: #2563eb; background: #e0f2fe; border-radius: 999px; padding: 6px 12px; }
    .kas-card { display: grid; gap: 20px; }
    .kas-summary { display: grid; gap: 12px; }
    .kas-summary .summary-row { display: flex; justify-content: space-between; align-items: center; gap: 10px; font-size: 14px; color: #334155; }
    .kas-summary .summary-row strong { font-weight: 700; }
    .kas-actions { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
    .btn-layanan { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 14px; border-radius: 14px; border: none; text-decoration: none; font-size: 13px; font-weight: 700; transition: background 0.2s ease; }
    .btn-primary { background: #2563eb; color: white; }
    .btn-secondary { background: #e2e8f0; color: #0f172a; }
    .service-footer { display: grid; gap: 8px; }
    .service-stat { display: grid; gap: 6px; }
    .service-stat span { font-size: 12px; color: #64748b; }
    .service-stat strong { font-size: 18px; color: #0f172a; }
</style>

@php
    $formattedPemasukan = number_format($totalPemasukan, 0, ',', '.');
    $formattedPengeluaran = number_format($totalPengeluaran, 0, ',', '.');
    $formattedSaldo = number_format($saldo, 0, ',', '.');
@endphp

<div class="layanan-shell">
    <div class="layanan-hero">
        <h2>Layanan</h2>
        <p>Layanan dan informasi desa yang penting untuk memudahkan pengelolaan kas, program warga, serta komunikasi RT/RW.</p>
    </div>

    <div class="service-grid">
        <div class="service-card kas-card">
            <div class="service-meta">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/kas.svg" alt="Kas" class="service-image">
                    <div>
                        <div class="service-title">Kas</div>
                        <div class="service-desc">Pemasukan, pengeluaran, dan saldo kas desa.</div>
                    </div>
                </div>
                <div class="service-icon"><i class="fas fa-wallet"></i></div>
            </div>

            <div class="kas-summary">
                <div class="summary-row"><span>Pemasukan</span><strong>Rp {{ $formattedPemasukan }}</strong></div>
                <div class="summary-row"><span>Pengeluaran</span><strong>Rp {{ $formattedPengeluaran }}</strong></div>
                <div class="summary-row"><span>Saldo</span><strong>Rp {{ $formattedSaldo }}</strong></div>
                <div class="summary-row"><span>Catatan Kas</span><strong>{{ $totalKas }} data</strong></div>
            </div>

            <div class="kas-actions">
                <a href="{{ route('pemasukan.index') }}" class="btn-layanan btn-secondary">Pemasukan</a>
                <a href="{{ route('pengeluaran.index') }}" class="btn-layanan btn-secondary">Pengeluaran</a>
                <a href="{{ route('laporan.kas') }}" class="btn-layanan btn-secondary">Laporan Kas</a>
                <a href="{{ route('kas.index') }}" class="btn-layanan btn-primary">Detail</a>
            </div>
        </div>

        <a href="{{ route('bank-sampah.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/bank-sampah.svg" alt="Bank Sampah" class="service-image">
                    <div>
                        <div class="service-title">Bank Sampah</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['bank-sampah'] }} data</div>
            </div>
            <div class="service-desc">Catat dan kelola transaksi bank sampah warga.</div>
        </a>

        <a href="{{ route('umkm.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/umkm.svg" alt="UMKM" class="service-image">
                    <div>
                        <div class="service-title">UMKM</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['umkm'] }} data</div>
            </div>
            <div class="service-desc">Data usaha mikro kecil menengah warga.</div>
        </a>

        <a href="{{ route('surat-menyurat.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/surat-menyurat.svg" alt="Surat Menyurat" class="service-image">
                    <div>
                        <div class="service-title">Surat Menyurat</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['surat-menyurat'] }} data</div>
            </div>
            <div class="service-desc">Manajemen surat desa dan administrasi.</div>
        </a>

        <a href="{{ route('posyandu.peserta.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/posyandu.svg" alt="Posyandu" class="service-image">
                    <div>
                        <div class="service-title">Posyandu</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['posyandu'] }} jadwal</div>
            </div>
            <div class="service-desc">Jadwal dan data kegiatan posyandu.</div>
        </a>

        <a href="{{ route('ronda.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/ronda.svg" alt="Keamanan Ronda" class="service-image">
                    <div>
                        <div class="service-title">Keamanan / Ronda</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['keamanan-ronda'] }} data</div>
            </div>
            <div class="service-desc">Jadwal ronda dan keamanan lingkungan.</div>
        </a>

        <a href="{{ route('kegiatan.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/kegiatan.svg" alt="Kegiatan Warga" class="service-image">
                    <div>
                        <div class="service-title">Kegiatan Warga</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['kegiatan-warga'] }} data</div>
            </div>
            <div class="service-desc">Kelola kegiatan dan acara warga.</div>
        </a>

        <a href="{{ route('warga.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/warga.svg" alt="Warga" class="service-image">
                    <div>
                        <div class="service-title">Warga</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['warga'] }} warga</div>
            </div>
            <div class="service-desc">Data warga RT/RW lengkap dan terstruktur.</div>
        </a>

        <a href="{{ route('aspirasi.index') }}" class="service-card">
            <div class="service-meta" style="align-items:center;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="/images/services/aspirasi.svg" alt="Aspirasi" class="service-image">
                    <div>
                        <div class="service-title">Aspirasi</div>
                    </div>
                </div>
                <div class="badge">{{ $serviceCounts['aspirasi'] }} data</div>
            </div>
            <div class="service-desc">Sampaikan aspirasi dan masukan warga.</div>
        </a>
    </div>
</div>
@endsection
