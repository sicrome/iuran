@extends('layouts.app')

@section('title', 'Tambah Jenis Iuran - Kas RT')
@section('page-title', 'Tambah Jenis Iuran Baru')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .form-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .form-group label .required {
        color: #ef4444;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
        transition: all 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .btn-submit {
        background: #3b82f6;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
        .form-card { padding: 20px; }
    }
</style>

<div class="form-card">
    <div class="form-title">
        <i class="fas fa-plus-circle" style="margin-right: 10px; color: #3b82f6;"></i> Tambah Jenis Iuran Baru
    </div>

    @if($errors->any())
    <div class="alert-error">
        <i class="fas fa-exclamation-triangle"></i> Periksa kembali data Anda:
        <ul style="margin-top: 8px; margin-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('jenis-iuran.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Jenis Iuran <span class="required">*</span></label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Iuran Warga" value="{{ old('nama') }}" required>
        </div>

        <div class="form-group">
            <label>Icon (Emoji) <span class="required">*</span></label>
            <input type="text" name="icon" class="form-control" placeholder="💰" value="{{ old('icon', '💰') }}" required>
            <small style="font-size: 11px; color: #64748b;">Contoh: 💰, 🧹, 🛡️, 🤝</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nominal Default (Rp) <span class="required">*</span></label>
                <input type="number" name="nominal_default" class="form-control" placeholder="100000" value="{{ old('nominal_default', 100000) }}" required>
            </div>
            <div class="form-group">
                <label>Denda per Hari (Rp) <span class="required">*</span></label>
                <input type="number" name="denda_per_hari" class="form-control" placeholder="5000" value="{{ old('denda_per_hari', 5000) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Batas Tanggal Pembayaran <span class="required">*</span></label>
                <select name="batas_tanggal" class="form-control" required>
                    @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}" {{ old('batas_tanggal', 25) == $i ? 'selected' : '' }}>Tanggal {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label>Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('jenis-iuran.index') }}" class="btn-cancel">Kembali</a>
        </div>
    </form>
</div>
@endsection