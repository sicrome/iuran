@extends('layouts.app')

@section('title', 'Edit Warga - Kas RT')
@section('page-title', 'Edit Data Warga')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 900px;
        margin: 0 auto;
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
    .btn-update {
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
        font-size: 14px;
        font-weight: 600;
        text-align: center;
    }
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .form-card { padding: 20px; }
    }
</style>

<div class="form-card">
    <div class="form-title">
        <i class="fas fa-user-edit" style="margin-right: 10px; color: #3b82f6;"></i> Edit Data Warga
    </div>

    @if($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:12px; margin-bottom:20px;">
        <ul style="margin-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('warga.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>NIK <span class="required">*</span></label>
                <input type="text" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}" placeholder="16 digit NIK">
            </div>
            <div class="form-group">
                <label>Nomor Kartu Keluarga (KK)</label>
                <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $user->no_kk) }}" placeholder="Nomor KK">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" placeholder="Nama sesuai KTP" required>
            </div>
            <div class="form-group">
                <label>Nama Panggilan <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Nama panggilan" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="email@example.com" required>
            </div>
            <div class="form-group">
                <label>No Telepon / HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08123456789">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" placeholder="Kota lahir">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <select name="agama" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Islam" {{ $user->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ $user->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ $user->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ $user->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ $user->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ $user->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Status Perkawinan</label>
                <select name="status_perkawinan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Belum Kawin" {{ $user->status_perkawinan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                    <option value="Kawin" {{ $user->status_perkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="Cerai Hidup" {{ $user->status_perkawinan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                    <option value="Cerai Mati" {{ $user->status_perkawinan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $user->pekerjaan) }}" placeholder="Pekerjaan">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>RT / RW</label>
                <input type="text" name="rt_rw" class="form-control" value="{{ old('rt_rw', $user->rt_rw) }}" placeholder="Contoh: 01/03">
            </div>
            <div class="form-group">
                <label>Role / Hak Akses <span class="required">*</span></label>
                <select name="role_id" class="form-control" required>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name }} ({{ $role->name }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <hr style="margin: 20px 0; border-color: #e2e8f0;">

        <div class="form-row">
            <div class="form-group">
                <label>Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control" placeholder="Password baru">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('warga.index') }}" class="btn-cancel">Kembali</a>
        </div>
    </form>
</div>
@endsection