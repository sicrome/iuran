@extends('layouts.app')

@section('title', 'Edit Data Kas - Desa Rafi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">✏️ Edit Data Kas</h5>
                </div>
                <div class="card-body">
                    @if($kas)
                        <form action="{{ route('kas.update', $kas->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Nama Warga</label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Warga --</option>
                                    @foreach($wargas as $warga)
                                    <option value="{{ $warga->id }}" {{ old('user_id', $kas->user_id) == $warga->id ? 'selected' : '' }}>
                                        {{ $warga->name }} ({{ $warga->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <input type="text" name="bulan" id="bulan" class="form-control @error('bulan') is-invalid @enderror" 
                                    placeholder="Contoh: Januari 2025" value="{{ old('bulan', $kas->bulan) }}" required>
                                @error('bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Transaksi</label>
                                <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="pemasukan" {{ old('jenis', $kas->jenis) == 'pemasukan' ? 'selected' : '' }}>
                                        💰 Pemasukan
                                    </option>
                                    <option value="pengeluaran" {{ old('jenis', $kas->jenis) == 'pengeluaran' ? 'selected' : '' }}>
                                        📤 Pengeluaran
                                    </option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nominal" class="form-label">Nominal (Rp)</label>
                                <input type="number" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror" 
                                    value="{{ old('nominal', $kas->nominal) }}" required>
                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                    value="{{ old('tanggal', $kas->tanggal) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $kas->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('kas.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </form>
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