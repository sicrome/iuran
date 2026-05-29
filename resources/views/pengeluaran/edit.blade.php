@extends('layouts.app')

@section('title', 'Edit Pengeluaran - Kas RT')
@section('page-title', 'Edit Pengeluaran')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #1f2937;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
    }
    .btn-submit {
        background: #f59e0b;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
    }
    .btn-back {
        background: #6b7280;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        display: inline-block;
    }
</style>

<div class="form-card">
    <h3 style="margin-bottom: 20px;">✏️ Edit Pengeluaran</h3>
    
    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Nama Warga</label>
            <select name="user_id" class="form-control" required>
                <option value="">Pilih Warga</option>
                @foreach($wargas as $warga)
                <option value="{{ $warga->id }}" {{ $pengeluaran->user_id == $warga->id ? 'selected' : '' }}>{{ $warga->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" value="{{ $pengeluaran->bulan }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Nominal (Rp)</label>
            <input type="number" name="nominal" class="form-control" value="{{ $pengeluaran->nominal }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $pengeluaran->tanggal }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ $pengeluaran->keterangan }}</textarea>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('pengeluaran.index') }}" class="btn-back">Kembali</a>
            <button type="submit" class="btn-submit">Update</button>
        </div>
    </form>
</div>
@endsection