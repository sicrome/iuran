@extends('layouts.app')

@section('title', 'Edit Pengumuman - Kas RT')
@section('page-title', 'Edit Pengumuman')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-edit"></i> Edit Pengumuman</div>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Icon Emoji</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $pengumuman->icon) }}" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Judul Pengumuman</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Isi Pengumuman</label>
                <textarea name="isi" class="form-control" rows="5" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" required>{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Status</label>
                <select name="status" class="form-control" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                    <option value="aktif" {{ $pengumuman->status == 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                    <option value="nonaktif" {{ $pengumuman->status == 'nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai) }}" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai) }}" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection