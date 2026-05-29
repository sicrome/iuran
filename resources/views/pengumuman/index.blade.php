@extends('layouts.app')

@section('title', 'Kelola Pengumuman - Kas RT')
@section('page-title', 'Kelola Pengumuman')

@section('content')
<style>
    .status-aktif { background: rgba(16,185,129,0.2); color: #6ee7b7; padding: 4px 12px; border-radius: 20px; font-size: 10px; }
    .status-nonaktif { background: rgba(239,68,68,0.2); color: #fca5a5; padding: 4px 12px; border-radius: 20px; font-size: 10px; }
</style>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-bullhorn"></i> Manajemen Pengumuman</div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('pengumuman.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Pengumuman</a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Icon</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumuman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span style="font-size: 24px;">{{ $item->icon }}</span></td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ Str::limit($item->isi, 50) }}</td>
                    <td><span class="{{ $item->status == 'aktif' ? 'status-aktif' : 'status-nonaktif' }}">{{ $item->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('pengumuman.toggle', $item->id) }}" class="btn btn-primary btn-sm">Toggle Status</a>
                        <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;">Belum ada pengumuman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $pengumuman->links() }}
</div>
@endsection