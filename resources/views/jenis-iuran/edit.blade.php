@extends('layouts.app')

@section('title', 'Edit Jenis Iuran - Kas RT')
@section('page-title', 'Edit Jenis Iuran')

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
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .btn-submit {
        background: #f59e0b;
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
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="form-card">
    <div class="form-title">
        <i class="fas fa-edit" style="margin-right: 10px; color: #f59e0b;"></i> Edit Jenis Iuran
    </div>

    @if($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:12px; margin-bottom:20px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('jenis-iuran.update', $jenisIuran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Jenis Iuran</label>
            <input type="text" name="nama" class="form-control" value="{{ $jenisIuran->nama }}" required>
        </div>

        <div class="form-group">
            <label>Icon (Emoji)</label>
            <input type="text" name="icon" class="form-control" value="{{ $jenisIuran->icon }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nominal Default (Rp)</label>
                <input type="number" name="nominal_default" class="form-control" value="{{ $jenisIuran->nominal_default }}" required>
            </div>
            <div class="form-group">
                <label>Denda per Hari (Rp)</label>
                <input type="number" name="denda_per_hari" class="form-control" value="{{ $jenisIuran->denda_per_hari }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Batas Tanggal Pembayaran</label>
                <select name="batas_tanggal" class="form-control" required>
                    @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}" {{ $jenisIuran->batas_tanggal == $i ? 'selected' : '' }}>Tanggal {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="aktif" {{ $jenisIuran->status == 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                    <option value="nonaktif" {{ $jenisIuran->status == 'nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('jenis-iuran.index') }}" class="btn-cancel">Kembali</a>
        </div>
    </form>
</div>
@endsection