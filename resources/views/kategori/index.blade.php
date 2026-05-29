@extends('layouts.app')

@section('title', 'Kategori - Kas RT')
@section('page-title', 'Manajemen Kategori')

@section('content')
<style>
    .kategori-card {
        background: linear-gradient(135deg, rgba(102,126,234,0.15), rgba(118,75,162,0.15));
        border-radius: 16px;
        padding: 16px;
        transition: all 0.2s;
    }
    .kategori-card:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, rgba(102,126,234,0.25), rgba(118,75,162,0.25));
    }
    .kategori-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .badge-type {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .badge-pemasukan { background: rgba(16,185,129,0.2); color: #6ee7b7; }
    .badge-pengeluaran { background: rgba(239,68,68,0.2); color: #fca5a5; }
    .table-kategori {
        width: 100%;
        border-collapse: collapse;
    }
    .table-kategori th, .table-kategori td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .table-kategori th {
        color: rgba(255,255,255,0.7);
        font-size: 11px;
        font-weight: 600;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-tags"></i> Kategori Transaksi</div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('kategori.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Kategori</a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table-kategori">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Icon</th>
                    <th>Nama Kategori</th>
                    <th>Tipe</th>
                    <th>Warna</th>
                    @if(auth()->user()->isAdmin())<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="kategori-icon" style="width: 35px; height: 35px; background: {{ $item->color ?? '#667eea' }}20;">
                            <i class="{{ $item->icon ?? 'fas fa-tag' }}" style="color: {{ $item->color ?? '#667eea' }}; font-size: 16px;"></i>
                        </div>
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <span class="badge-type {{ $item->type == 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' }}">
                            {{ $item->type == 'pemasukan' ? '💰 Pemasukan' : '📤 Pengeluaran' }}
                        </span>
                    </td>
                    <td>
                        <div style="width: 30px; height: 20px; background: {{ $item->color ?? '#667eea' }}; border-radius: 6px;"></div>
                    </td>
                    @if(auth()->user()->isAdmin())
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px;">
                        <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.5;"></i>
                        <p style="margin-top: 10px;">Belum ada kategori. Silakan tambah kategori baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 16px;">{{ $kategoris->links() }}</div>
</div>
@endsection