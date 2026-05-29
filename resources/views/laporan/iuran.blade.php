@extends('layouts.app')

@section('title', 'Laporan Iuran - Kas RT')
@section('page-title', 'Laporan Iuran Warga')

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
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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
    .stat-icon {
        font-size: 32px;
        margin-bottom: 10px;
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
    .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-excel {
        background: #10b981;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-pdf {
        background: #dc2626;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-print {
        background: #3b82f6;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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
        padding: 10px 15px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
    .data-table tr:hover td {
        background: #f8fafc;
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
    .pagination .active span {
        background: #3b82f6;
        color: white;
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .table-title { flex-direction: column; align-items: flex-start; }
        .data-table th, .data-table td { padding: 8px; font-size: 11px; }
    }
</style>

<div class="page-header">
    <h2>Laporan Iuran Warga</h2>
    <p>Rekapitulasi iuran warga RT</p>
</div>

<!-- Statistik Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
        <div class="stat-label">Total Iuran Lunas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-value">Rp {{ number_format($totalBelum, 0, ',', '.') }}</div>
        <div class="stat-label">Total Belum Dibayar</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-value">{{ $iuran->total() }}</div>
        <div class="stat-label">Total Transaksi</div>
    </div>
</div>

<!-- Tabel Iuran -->
<div class="card-table">
    <div class="table-title">
        <span><i class="fas fa-list-ul"></i> Detail Iuran Warga</span>
        <div class="btn-group">
            <a href="{{ route('export.iuran') }}" class="btn-excel">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('export.pdf.iuran') }}" class="btn-pdf">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Warga</th>
                    <th>Bulan/Tahun</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($iuran as $item)
                <tr>
                    <td style="width: 50px;">{{ $loop->iteration }}</td>
                    <td><strong>{{ $item->user->name }}</strong></td>
                    <td>{{ $item->bulan_tahun }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        @if($item->status == 'lunas')
                            <span class="badge-lunas">✅ Lunas</span>
                        @else
                            <span class="badge-belum">❌ Belum</span>
                        @endif
                    </td>
                    <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        <i class="fas fa-inbox" style="font-size: 40px; color: #cbd5e1;"></i>
                        <p style="margin-top: 10px;">Belum ada data iuran</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($iuran->hasPages())
    <div class="pagination">
        {{ $iuran->links() }}
    </div>
    @endif
</div>

<style>
    @media print {
        .sidebar, .top-navbar, .btn-group, .logout-btn, .pagination {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
        }
        .card-table, .stat-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        .badge-lunas, .badge-belum {
            background: none;
            border: 1px solid;
        }
    }
</style>
@endsection