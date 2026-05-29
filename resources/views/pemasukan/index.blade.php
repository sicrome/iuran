@extends('layouts.app')

@section('title', 'Pemasukan - Kas RT')
@section('page-title', 'Data Pemasukan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-arrow-down text-success"></i> Data Pemasukan</div>
        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
        <a href="{{ route('pemasukan.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Pemasukan</a>
        @endif
    </div>

    <div style="background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(16,185,129,0.1)); border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <div style="font-size: 28px; font-weight: 800; color: #6ee7b7;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div style="font-size: 12px; color: rgba(255,255,255,0.6);">Total Seluruh Pemasukan</div>
        </div>
        <div><i class="fas fa-chart-pie" style="font-size: 40px; color: #6ee7b7; opacity: 0.8;"></i></div>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr><th>No</th><th>Warga</th><th>Bulan</th><th>Nominal</th><th>Tanggal</th><th>Keterangan</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pemasukan as $item)
                <tr>
                    <td style="width: 50px;">{{ $loop->iteration }}</td>
                    <td><i class="fas fa-user-circle"></i> {{ $item->user->name }}</td>
                    <td>{{ $item->bulan }}</td>
                    <td style="color: #6ee7b7; font-weight: bold;">Rp {{ number_format($item->nominal,0,',','.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                        <a href="{{ route('pemasukan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pemasukan.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                        @else
                        <span class="badge-pemasukan">Lihat</span>
                        @endif
                    </td>
                </tr>
                @empty
                <td><td colspan="7" style="text-align:center;">Belum ada data pemasukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-custom">{{ $pemasukan->links('pagination::bootstrap-4') }}</div>
</div>

<style>
    .badge-pemasukan {
        background: rgba(16,185,129,0.2);
        color: #6ee7b7;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
    }
</style>
@endsection