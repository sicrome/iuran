@extends('layouts.app')

@section('title', 'Tambah Pengumuman - Kas RT')
@section('page-title', 'Tambah Pengumuman')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-plus"></i> Tambah Pengumuman Baru</div>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pengumuman.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Icon Emoji</label>
                <input type="text" name="icon" class="form-control" placeholder="📢" value="{{ old('icon', '📢') }}" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                <small style="color: rgba(255,255,255,0.4);">Contoh: 📢, 🎉, ⚠️, 💰, 📅</small>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Judul Pengumuman</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul pengumuman" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Isi Pengumuman</label>
                <textarea name="isi" class="form-control" rows="5" placeholder="Masukkan isi pengumuman..." style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" required></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Status</label>
                <select name="status" class="form-control" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                    <option value="aktif">✅ Aktif</option>
                    <option value="nonaktif">❌ Nonaktif</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Tanggal Mulai (Opsional)</label>
                    <input type="date" name="tanggal_mulai" class="form-control" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Tanggal Selesai (Opsional)</label>
                    <input type="date" name="tanggal_selesai" class="form-control" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Pengumuman</button>
            </div>
        </form>
    </div>
</div>
@endsection