@extends('layouts.app')

@section('title', 'Dashboard Warga - Kas RT')
@section('page-title', 'Dashboard Warga')

@section('content')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 20px;
        padding: 20px 25px;
        margin-bottom: 25px;
        color: white;
    }
    .welcome-card h2 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .welcome-card p {
        font-size: 13px;
        opacity: 0.9;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
    }
    .stat-label {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
    }
    .stat-sub {
        font-size: 11px;
        color: #10b981;
        margin-top: 5px;
    }
    .card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .empty-state {
        text-align: center;
        padding: 30px;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background: #f8fafc;
        padding: 12px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 10px 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
    .badge-lunas {
        background: #d1fae5;
        color: #10b981;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    .badge-belum {
        background: #fee2e2;
        color: #ef4444;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    .btn-lihat {
        background: #3b82f6;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div>
    <div class="welcome-card">
        <h2>Halo, {{ $user->name }}!</h2>
        <p>Kelola pembayaran iuran Anda dengan mudah</p>
    </div>

    <!-- Statistik -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($totalSudahBayar, 0, ',', '.') }}</div>
            <div class="stat-label">TOTAL SUDAH BAYAR</div>
            <div class="stat-sub">{{ $totalTransaksiLunas }} transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</div>
            <div class="stat-label">TOTAL BELUM BAYAR</div>
            <div class="stat-sub">{{ $totalTagihanBelum }} tagihan</div>
        </div>
    </div>

    <!-- Tagihan Belum Lunas -->
    <div class="card">
        <div class="card-title">
            <span><i class="fas fa-clock"></i> Tagihan Belum Lunas</span>
        </div>
        @if($tagihanBelumLunas->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Bulan/Tahun</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tagihanBelumLunas as $item)
                        <tr>
                            <td>{{ $item->bulan_tahun }}</td>
                            <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td><span class="badge-belum">Belum Bayar</span></td>
                            <td>
                                <a href="{{ route('pembayaran.create') }}" class="btn-lihat" style="background: #10b981; padding: 4px 10px;">Bayar Sekarang</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                <p>Tidak ada tagihan, semua iuran sudah lunas!</p>
            </div>
        @endif
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="card">
        <div class="card-title">
            <span><i class="fas fa-history"></i> Riwayat Pembayaran</span>
            <a href="{{ route('iuran.index') }}" class="btn-lihat">LIHAT SEMUA →</a>
        </div>
        @if($riwayatPembayaran->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <th>Jenis Iuran</th>
                            <th>Bulan/Tahun</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatPembayaran as $item)
                        <tr>
                            <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                            <td>Iuran Warga</td>
                            <td>{{ $item->bulan_tahun }}</td>
                            <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td><span class="badge-lunas">Lunas</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <p>Belum ada riwayat pembayaran</p>
                <a href="{{ route('pembayaran.create') }}" class="btn-lihat" style="margin-top: 10px; display: inline-block;">Bayar Iuran Sekarang</a>
            </div>
        @endif
    </div>
</div>
@endsection