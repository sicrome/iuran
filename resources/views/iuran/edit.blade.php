@extends('layouts.app')

@section('title', 'Edit Iuran - Kas RT')
@section('page-title', 'Edit Iuran Warga')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">✏️ Edit Iuran Warga</div>
        <a href="{{ route('iuran.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('iuran.update', $iuran->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; font-weight:500;">Nama Warga</label>
                <select name="user_id" class="form-control" style="width:100%; padding:6px; border:1px solid #e5e7eb; border-radius:6px; font-size:11px;" required>
                    <option value="">Pilih Warga</option>
                    @foreach($wargas as $warga)
                    <option value="{{ $warga->id }}" {{ $iuran->user_id == $warga->id ? 'selected' : '' }}>{{ $warga->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; font-weight:500;">Bulan/Tahun</label>
                <input type="text" name="bulan_tahun" class="form-control" value="{{ $iuran->bulan_tahun }}" style="width:100%; padding:6px; border:1px solid #e5e7eb; border-radius:6px; font-size:11px;" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; font-weight:500;">Nominal (Rp)</label>
                <input type="number" name="nominal" class="form-control" value="{{ $iuran->nominal }}" style="width:100%; padding:6px; border:1px solid #e5e7eb; border-radius:6px; font-size:11px;" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; font-weight:500;">Status</label>
                <select name="status" class="form-control" style="width:100%; padding:6px; border:1px solid #e5e7eb; border-radius:6px; font-size:11px;" required>
                    <option value="belum" {{ $iuran->status == 'belum' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="lunas" {{ $iuran->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 12px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; font-weight:500;">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ $iuran->tanggal_bayar }}" style="width:100%; padding:6px; border:1px solid #e5e7eb; border-radius:6px; font-size:11px;">
            </div>
            
            <div style="display: flex; gap: 8px; margin-top: 15px;">
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('iuran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection