@extends('layouts.app')

@section('title', 'Edit Kategori - Kas RT')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-edit"></i> Edit Kategori</div>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $kategori->name) }}" class="form-control" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Tipe</label>
                <select name="type" class="form-control" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" required>
                    <option value="pemasukan" {{ $kategori->type == 'pemasukan' ? 'selected' : '' }}>💰 Pemasukan</option>
                    <option value="pengeluaran" {{ $kategori->type == 'pengeluaran' ? 'selected' : '' }}>📤 Pengeluaran</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Icon (Font Awesome)</label>
                <input type="text" name="icon" value="{{ old('icon', $kategori->icon) }}" class="form-control" placeholder="fas fa-hand-holding-usd" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;">
                <small style="color: rgba(255,255,255,0.4);">Contoh: fas fa-hand-holding-usd | fas fa-broom | fas fa-tools</small>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7);">Warna</label>
                <input type="color" name="color" value="{{ old('color', $kategori->color ?? '#667eea') }}" style="width: 60px; height: 40px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;">
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection