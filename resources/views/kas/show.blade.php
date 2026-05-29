@extends('layouts.app')

@section('title', 'Detail Kas - Desa Rafi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📄 Detail Data Kas</h5>
                </div>
                <div class="card-body">
                    @if($kas)
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px; background-color: #f8f9fa;">Nama Warga</th>
                                <td>
                                    @if($kas->user)
                                        <strong>{{ $kas->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $kas->user->email }}</small>
                                    @else
                                        <span class="text-danger">User tidak ditemukan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Bulan</th>
                                <td>{{ $kas->bulan }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Jenis Transaksi</th>
                                <td>
                                    @if($kas->jenis == 'pemasukan')
                                        <span class="badge bg-success">💰 Pemasukan</span>
                                    @else
                                        <span class="badge bg-danger">📤 Pengeluaran</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Nominal</th>
                                <td class="fw-bold fs-5">
                                    Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Tanggal</th>
                                <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Keterangan</th>
                                <td>{{ $kas->keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Dibuat Pada</th>
                                <td>{{ $kas->created_at ? $kas->created_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Terakhir Update</th>
                                <td>{{ $kas->updated_at ? $kas->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('kas.index') }}" class="btn btn-secondary">
                                ← Kembali
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
                            <div>
                                <a href="{{ route('kas.edit', $kas->id) }}" class="btn btn-warning">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('kas.destroy', $kas->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-danger">
                            Data tidak ditemukan!
                        </div>
                        <a href="{{ route('kas.index') }}" class="btn btn-secondary">Kembali</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection