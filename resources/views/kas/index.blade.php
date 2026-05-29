@extends('layouts.app')

@section('title', 'Data Kas Desa Rafi')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📋 Data Kas Desa</h2>
        @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
        <a href="{{ route('kas.create') }}" class="btn btn-primary">
            ➕ Tambah Data
        </a>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Warga</th>
                            <th>Bulan</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->bulan }}</td>
                            <td>
                                @if($item->jenis == 'pemasukan')
                                    <span class="badge bg-success">💰 Pemasukan</span>
                                @else
                                    <span class="badge bg-danger">📤 Pengeluaran</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('kas.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                                @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                                <a href="{{ route('kas.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('kas.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data kas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $kas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection