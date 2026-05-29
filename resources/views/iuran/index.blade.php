@extends('layouts.app')

@section('title', 'Data Iuran - Kas RT')
@section('page-title', 'Data Iuran Warga')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .page-header h2 { font-size: 24px; font-weight: 700; color: #1e293b; }
    .stats-iuran {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
    .stat-value { font-size: 28px; font-weight: 800; color: #1e293b; }
    .stat-label { font-size: 12px; color: #64748b; margin-top: 5px; }
    .data-table {
        width: 100%;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border-collapse: collapse;
    }
    .data-table th {
        background: #f8fafc;
        padding: 14px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
    .badge-lunas { background: #d1fae5; color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 11px; display: inline-block; }
    .badge-belum { background: #fee2e2; color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 11px; display: inline-block; }
    .badge-pending { background: #fed7aa; color: #f59e0b; padding: 4px 12px; border-radius: 20px; font-size: 11px; display: inline-block; }
    .badge-diterima { background: #d1fae5; color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 11px; display: inline-block; }
    .badge-ditolak { background: #fee2e2; color: #dc2626; padding: 4px 12px; border-radius: 20px; font-size: 11px; display: inline-block; }
    .btn-edit { background: #f59e0b; color: white; padding: 5px 12px; border-radius: 8px; text-decoration: none; font-size: 11px; }
    .btn-verify { background: #3b82f6; color: white; padding: 5px 12px; border-radius: 8px; text-decoration: none; font-size: 11px; }
    .pagination { display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px; }
    .pagination a, .pagination span { padding: 6px 12px; background: #f1f5f9; border-radius: 8px; color: #1e293b; text-decoration: none; font-size: 12px; }
    .pagination .active span { background: #3b82f6; color: white; }
    @media (max-width: 768px) { .stats-iuran { grid-template-columns: 1fr; } }
</style>

<div>
    <div class="page-header">
        <div><h2>Data Iuran Warga</h2><p>Kelola data iuran dan verifikasi pembayaran</p></div>
        <div><a href="{{ route('iuran.create') }}" class="btn btn-success" style="background:#10b981; color:white; padding:10px 20px; border-radius:12px; text-decoration:none;"><i class="fas fa-plus"></i> Tambah Iuran</a></div>
    </div>

    <div class="stats-iuran">
        <div class="stat-card"><div class="stat-value">Rp {{ number_format($totalLunas,0,',','.') }}</div><div class="stat-label">Total Lunas</div></div>
        <div class="stat-card"><div class="stat-value">Rp {{ number_format($totalBelum,0,',','.') }}</div><div class="stat-label">Total Belum Bayar</div></div>
        <div class="stat-card"><div class="stat-value">{{ $pendingVerifikasi }}</div><div class="stat-label">Menunggu Verifikasi</div></div>
        <div class="stat-card"><div class="stat-value">Rp {{ number_format($totalLunas + $totalBelum,0,',','.') }}</div><div class="stat-label">Total Keseluruhan</div></div>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead><th>No</th><th>Nama Warga</th><th>Bulan/Tahun</th><th>Nominal</th><th>Status</th><th>Status Verifikasi</th><th>Tgl Bayar</th><th>Aksi</th></thead>
            <tbody>
                @forelse($iuran as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $item->user->name }}</strong></td>
                    <td>{{ $item->bulan_tahun }}</td>
                    <td>Rp {{ number_format($item->nominal,0,',','.') }}</td>
                    <td>@if($item->status == 'lunas')<span class="badge-lunas">✅ Lunas</span>@else<span class="badge-belum">❌ Belum</span>@endif</td>
                    <td>@if($item->verifikasi_status == 'pending')<span class="badge-pending">🔄 Menunggu</span>@elseif($item->verifikasi_status == 'diterima')<span class="badge-diterima">✅ Diverifikasi</span>@else<span class="badge-ditolak">❌ Ditolak</span>@endif</td>
                    <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                    <td><a href="{{ route('iuran.edit', $item->id) }}" class="btn-edit">Edit</a>@if($item->verifikasi_status == 'pending')<a href="{{ route('iuran.verify', $item->id) }}" class="btn-verify">Verifikasi</a>@endif</td>
                </tr>
                @empty <tr><td colspan="8" style="text-align:center;">Belum ada data iuran</td></tr>@endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $iuran->links() }}</div>
</div>
@endsection