@extends('layouts.app')

@section('title', 'Edit Pengurus - Kas RT')
@section('page-title', 'Edit Pengurus RT')

@section('content')
<div class="card">
    <div class="card-title">✏️ Edit Pengurus</div>
    
    <form action="{{ route('pengurus.update', $pengurus->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $pengurus->nama) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan', $pengurus->jabatan) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">No Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengurus->no_telepon) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Alamat</label>
            <textarea name="alamat" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" rows="3" required>{{ old('alamat', $pengurus->alamat) }}</textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Tahun Mulai Jabatan</label>
            <input type="number" name="masa_jabatan_mulai" value="{{ old('masa_jabatan_mulai', $pengurus->masa_jabatan_mulai) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Tahun Selesai Jabatan</label>
            <input type="number" name="masa_jabatan_selesai" value="{{ old('masa_jabatan_selesai', $pengurus->masa_jabatan_selesai) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Status</label>
            <select name="status" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                <option value="aktif" {{ $pengurus->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $pengurus->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('pengurus.index') }}" style="background: #6c757d; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Kembali</a>
            <button type="submit" style="background: #ffc107; color: #333; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">Update</button>
        </div>
    </form>
</div>
@endsection