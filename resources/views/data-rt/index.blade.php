@extends('layouts.app')

@section('title', 'Data RT - Kas RT')
@section('page-title', 'Data RT')

@section('content')
<div class="card">
    <div class="card-title">🏘️ Profil RT</div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('data-rt.update', $dataRt->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama RT</label>
                <input type="text" name="nama_rt" value="{{ old('nama_rt', $dataRt->nama_rt) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kode Pos</label>
                <input type="text" name="kode_pos" value="{{ old('kode_pos', $dataRt->kode_pos) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kelurahan</label>
                <input type="text" name="kelurahan" value="{{ old('kelurahan', $dataRt->kelurahan) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $dataRt->kecamatan) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kabupaten/Kota</label>
                <input type="text" name="kabupaten" value="{{ old('kabupaten', $dataRt->kabupaten) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', $dataRt->provinsi) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email</label>
                <input type="email" name="email" value="{{ old('email', $dataRt->email) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $dataRt->no_telepon) }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" rows="4" required>{{ old('alamat_lengkap', $dataRt->alamat_lengkap) }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #28a745; color: white; padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer;">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<style>
    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>
@endsection