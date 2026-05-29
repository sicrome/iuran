@extends('layouts.app')

@section('title', 'Tambah Pengurus - Kas RT')
@section('page-title', 'Tambah Pengurus RT')

@section('content')
<div class="card">
    <div class="card-title">➕ Tambah Pengurus Baru</div>
    
    <form action="{{ route('pengurus.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">No Telepon</label>
            <input type="text" name="no_telepon" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Alamat</label>
            <textarea name="alamat" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" rows="3" required></textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Tahun Mulai Jabatan</label>
            <input type="number" name="masa_jabatan_mulai" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Tahun Selesai Jabatan</label>
            <input type="number" name="masa_jabatan_selesai" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Status</label>
            <select name="status" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('pengurus.index') }}" style="background: #6c757d; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Kembali</a>
            <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">Simpan</button>
        </div>
    </form>
</div>

<style>
    .form-control:focus {
        outline: none;
        border-color: #667eea;
    }
</style>
@endsection