@extends('layouts.app')

@section('title', 'Laporan Buku Kas - Kas RT')
@section('page-title', 'Laporan Buku Kas')

@section('content')
<style>
    /* Header Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: linear-gradient(135deg, rgba(102,126,234,0.25), rgba(118,75,162,0.25));
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.15);
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        background: linear-gradient(135deg, rgba(102,126,234,0.35), rgba(118,75,162,0.35));
    }
    .stat-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e0d4ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
    }
    .stat-label {
        font-size: 13px;
        color: #d1d5db;
        font-weight: 500;
    }

    /* Table Container */
    .table-container {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .table-title {
        font-size: 18px;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #c4b5fd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    /* Data Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        text-align: left;
        padding: 14px 12px;
        background: rgba(0, 0, 0, 0.3);
        color: #e0e7ff;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .data-table td {
        padding: 12px;
        color: #f3f4f6;
        font-size: 13px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .data-table tr:hover td {
        background: rgba(255, 255, 255, 0.05);
    }

    /* Badge */
    .badge-pemasukan {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid rgba(16, 185, 129, 0.3);
        display: inline-block;
    }
    .badge-pengeluaran {
        background: rgba(239, 68, 68, 0.2);
        color: #fca5a5;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid rgba(239, 68, 68, 0.3);
        display: inline-block;
    }

    /* Nominal Amount */
    .amount-pemasukan {
        color: #6ee7b7;
        font-weight: 700;
    }
    .amount-pengeluaran {
        color: #fca5a5;
        font-weight: 700;
    }

    /* Print Button */
    .btn-print {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
        margin-bottom: 20px;
    }
    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.4);
    }

    /* Pagination */
    .pagination {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination a, .pagination span {
        padding: 6px 12px;
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        color: white;
        text-decoration: none;
        font-size: 12px;
    }
    .pagination .active span {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    /* Print Style */
    @media print {
        .sidebar, .top-navbar, .btn-print, .logout-btn {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
        }
        .stat-card {
            background: white;
            border: 1px solid #ddd;
        }
        .stat-value {
            -webkit-text-fill-color: #333;
            color: #333;
        }
        .data-table th {
            background: #f0f0f0;
            color: #333;
        }
        .data-table td {
            color: #333;
        }
        .badge-pemasukan, .badge-pengeluaran {
            background: #f0f0f0;
            color: #333;
        }
    }
</style>

<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="table-title">
            <i class="fas fa-book"></i> Laporan Buku Kas RT
        </div>
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pemasukan</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📤</div>
            <div class="stat-value">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pengeluaran</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💵</div>
            <div class="stat-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            <div class="stat-label">Saldo Akhir</div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="table-container">
        <div class="table-title">
            <i class="fas fa-list-ul"></i> Detail Transaksi Kas
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Warga</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            <span class="{{ $item->jenis == 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' }}">
                                {{ $item->jenis == 'pemasukan' ? '💰 Pemasukan' : '📤 Pengeluaran' }}
                            </span>
                        </td>
                        <td class="{{ $item->jenis == 'pemasukan' ? 'amount-pemasukan' : 'amount-pengeluaran' }}">
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 50px;">
                            <i class="fas fa-inbox" style="font-size: 48px; opacity: 0.5;"></i>
                            <p style="margin-top: 10px;">Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($transaksi, 'links'))
        <div class="pagination">
            {{ $transaksi->links() }}
        </div>
        @endif
    </div>
</div>
@endsection