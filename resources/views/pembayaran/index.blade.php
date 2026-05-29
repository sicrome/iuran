@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran - Kas RT')
@section('page-title', 'Verifikasi Pembayaran Iuran')

@section('content')
<style>
    .page-header {
        margin-bottom: 25px;
    }
    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }
    .page-header p {
        font-size: 13px;
        color: #64748b;
    }
    .stats-pembayaran {
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
    .stat-icon { font-size: 32px; margin-bottom: 10px; }
    .stat-value { font-size: 28px; font-weight: 800; color: #1e293b; }
    .stat-label { font-size: 12px; color: #64748b; margin-top: 5px; }
    .card-table {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow-x: auto;
    }
    .table-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .btn-refresh {
        background: #3b82f6;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-verify {
        background: #10b981;
        color: white;
        padding: 5px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-bukti {
        background: #8b5cf6;
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 11px;
        display: inline-block;
    }
    .badge-diterima {
        background: #d1fae5;
        color: #10b981;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-pending {
        background: #fed7aa;
        color: #f59e0b;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background: #f8fafc;
        padding: 12px 15px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 12px 15px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
    .data-table tr:hover td { background: #f8fafc; }
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 20px;
    }
    .pagination a, .pagination span {
        padding: 6px 12px;
        background: #f1f5f9;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        font-size: 12px;
    }
    .pagination .active span { background: #3b82f6; color: white; }
    @media (max-width: 768px) {
        .stats-pembayaran { grid-template-columns: 1fr; }
        .data-table th, .data-table td { padding: 8px; font-size: 11px; }
    }
</style>

<div class="page-header">
    <h2>Verifikasi Pembayaran Iuran</h2>
    <p>Kelola dan verifikasi pembayaran iuran warga</p>
</div>

<!-- Statistik -->
<div class="stats-pembayaran">
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-value">{{ $totalPending }}</div>
        <div class="stat-label">Menunggu Verifikasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value">{{ $totalDiterima }}</div>
        <div class="stat-label">Diterima</div>
    </div>
</div>

<!-- Tabel Pembayaran -->
<div class="card-table">
    <div class="table-title">
        <span><i class="fas fa-list-ul"></i> Daftar Pembayaran</span>
        <a href="{{ route('pembayaran.index') }}" class="btn-refresh">
            <i class="fas fa-sync-alt"></i> Refresh
        </a>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Warga</th>
                    <th>Bulan/Tahun</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Tgl Konfirmasi</th>
                    @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $item->user->name }}</strong></td>
                    <td>{{ $item->bulan_tahun }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td style="width: 100px;">
                        @if($item->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn-bukti">
                                <i class="fas fa-image"></i> Lihat Bukti
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->verifikasi_status == 'pending')
                            <span class="badge-pending">⏳ Menunggu Verifikasi</span>
                        @elseif($item->verifikasi_status == 'diterima')
                            <span class="badge-diterima">✅ Diterima</span>
                        @else
                            <span class="badge-pending">⏳ Menunggu Verifikasi</span>
                        @endif
                    </td>
                    <td>{{ $item->tanggal_verifikasi ? \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y H:i') : '-' }}</td>
                    @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                    <td style="width: 150px;">
                        @if($item->verifikasi_status == 'pending')
                            <a href="{{ route('pembayaran.verify', $item->id) }}" class="btn-verify">
                                <i class="fas fa-check-double"></i> Verifikasi
                            </a>
                        @elseif($item->verifikasi_status == 'diterima')
                            <span class="badge-diterima">
                                <i class="fas fa-check-circle"></i> Sudah Terverifikasi
                            </span>
                        @else
                            <span class="badge-pending">⏳ Menunggu</span>
                        @endif
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ (auth()->user()->isAdmin() || auth()->user()->isBendahara()) ? 8 : 7 }}" style="text-align: center; padding: 40px;">
                        <i class="fas fa-inbox" style="font-size: 40px; color: #cbd5e1;"></i>
                        <p style="margin-top: 10px;">Belum ada data pembayaran</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pembayaran->hasPages())
    <div class="pagination">
        {{ $pembayaran->links() }}
    </div>
    @endif
</div>
@endsection