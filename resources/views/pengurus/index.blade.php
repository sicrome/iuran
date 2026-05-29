@extends('layouts.app')

@section('title', 'Pengurus RT - Kas RT')
@section('page-title', 'Data Pengurus RT')

@section('content')
<style>
    .stats-pengurus {
        background: linear-gradient(135deg, rgba(168,85,247,0.2), rgba(168,85,247,0.1));
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid rgba(168,85,247,0.3);
    }
    .stats-pengurus .total { font-size: 28px; font-weight: 800; color: #c084fc; }
    .badge-aktif { background: rgba(16,185,129,0.2); color: #6ee7b7; padding: 4px 12px; border-radius: 20px; font-size: 11px; }
    .badge-nonaktif { background: rgba(239,68,68,0.2); color: #fca5a5; padding: 4px 12px; border-radius: 20px; font-size: 11px; }
    .btn { padding: 5px 12px; border-radius: 8px; font-size: 11px; }
    .btn-success { background: #10b981; color: white; }
    .btn-warning { background: #f59e0b; color: white; }
    .btn-danger { background: #ef4444; color: white; }
    .pagination { display: flex; gap: 8px; justify-content: center; margin-top: 20px; }
    .pagination a, .pagination span { padding: 6px 12px; background: rgba(255,255,255,0.1); border-radius: 8px; color: white; text-decoration: none; font-size: 12px; }
    .pagination .active span { background: #6366f1; }
</style>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-user-tie"></i> Data Pengurus RT</div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('pengurus.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Pengurus</a>
        @endif
    </div>

    <div class="stats-pengurus">
        <div><div class="total">{{ $pengurus->total() }} Orang</div><div>Total Pengurus Aktif</div></div>
        <div><i class="fas fa-user-tie" style="font-size: 40px; opacity: 0.8;"></i></div>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead><tr><th>No</th><th>Nama</th><th>Jabatan</th><th>No Telepon</th><th>Masa Jabatan</th><th>Status</th>@if(auth()->user()->isAdmin())<th>Aksi</th>@endif</thead>
            <tbody>
                @forelse($pengurus as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><i class="fas fa-user-circle"></i> {{ $item->nama }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->no_telepon }}</td>
                    <td>{{ $item->masa_jabatan_mulai }} - {{ $item->masa_jabatan_selesai }}</td>
                    <td><span class="badge-{{ $item->status }}">{{ $item->status == 'aktif' ? '✅ Aktif' : '❌ Nonaktif' }}</span></td>
                    @if(auth()->user()->isAdmin())
                    <td><a href="{{ route('pengurus.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pengurus.destroy', $item->id) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button></form></td>
                    @endif
                </tr>
                @empty <tr><td colspan="7" style="text-align:center;">Belum ada data pengurus</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $pengurus->links() }}</div>
</div>
@endsection