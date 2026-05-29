@extends('layouts.app')

@section('title', 'Pengeluaran - Kas RT')
@section('page-title', 'Data Pengeluaran')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-arrow-up text-danger"></i> Data Pengeluaran</div>
        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
        <a href="{{ route('pengeluaran.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Pengeluaran</a>
        @endif
    </div>

    <div style="background: linear-gradient(135deg, rgba(239,68,68,0.2), rgba(239,68,68,0.1)); border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
        <div><div style="font-size: 28px; font-weight: 800; color: #fca5a5;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div><div style="font-size: 12px; color: rgba(255,255,255,0.6);">Total Seluruh Pengeluaran</div></div>
        <div><i class="fas fa-chart-pie" style="font-size: 40px; color: #fca5a5; opacity: 0.8;"></i></div>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead><th>No</th><th>Warga</th><th>Bulan</th><th>Nominal</th><th>Tanggal</th><th>Keterangan</th>@if(auth()->user()->isAdmin() || auth()->user()->isBendahara())<th>Aksi</th>@endif</thead>
            <tbody>
                @forelse($pengeluaran as $item)
                <tr><td>{{ $loop->iteration }}</td><td>{{ $item->user->name }}</td><td>{{ $item->bulan }}</td><td style="color:#fca5a5; font-weight:bold;">Rp {{ number_format($item->nominal,0,',','.') }}</td><td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td><td>{{ $item->keterangan ?? '-' }}</td>@if(auth()->user()->isAdmin() || auth()->user()->isBendahara())<td><a href="{{ route('pengeluaran.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a> <form action="{{ route('pengeluaran.destroy', $item->id) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button></form></td>@endif</tr>
                @empty
                <tr><td colspan="7" style="text-align:center;">Belum ada data pengeluaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-custom">{{ $pengeluaran->links('pagination::bootstrap-4') }}</div>
</div>
@endsection