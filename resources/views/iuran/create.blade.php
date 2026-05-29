@extends('layouts.app')

@section('title', 'Tambah Iuran - Kas RT')
@section('page-title', 'Tambah Iuran Warga')

@section('content')
<style>
    .page-header {
        margin-bottom: 25px;
    }
    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }
    .page-header p {
        font-size: 13px;
        color: #64748b;
    }
    .form-card {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        padding: 30px;
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
    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .upload-area:hover {
        border-color: #3b82f6;
        background: #f8fafc;
    }
    .upload-area i {
        font-size: 40px;
        color: #94a3b8;
        margin-bottom: 10px;
    }
    .upload-area p {
        font-size: 12px;
        color: #64748b;
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
        width: 100%;
        transition: all 0.2s;
    }
    .btn-submit:hover {
        background: #2563eb;
        transform: translateY(-1px);
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
        width: 100%;
    }
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
    .status-hint {
        background: #fef3c7;
        padding: 10px 12px;
        border-radius: 10px;
        margin-top: 8px;
        font-size: 12px;
        color: #92400e;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .form-card { margin: 0 15px; }
    }
</style>

<div class="page-header">
    <h2>Tambah Iuran Warga</h2>
    <p>Form pembayaran iuran warga</p>
</div>

<div class="form-card">
    <div class="form-title">
        <i class="fas fa-hand-holding-usd" style="margin-right: 10px; color: #3b82f6;"></i> Form Pembayaran Iuran
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

    <form action="{{ route('iuran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama Warga <span class="required">*</span></label>
            <select name="user_id" class="form-control" required>
                <option value="">Pilih Warga</option>
                @foreach($wargas as $warga)
                <option value="{{ $warga->id }}" {{ old('user_id') == $warga->id ? 'selected' : '' }}>
                    {{ $warga->name }} ({{ $warga->email }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>RT / RW <span class="required">*</span></label>
                <input type="text" name="rt_rw" class="form-control" placeholder="Contoh: 01/03" value="{{ old('rt_rw', '01/05') }}">
            </div>
            <div class="form-group">
                <label>Jenis Iuran <span class="required">*</span></label>
                <select name="jenis_iuran" class="form-control" required id="jenisIuranSelect">
                    <option value="">Pilih Jenis Iuran</option>
                    <option value="Iuran Warga" data-nominal="100000">💰 Iuran Warga (Rp 100.000)</option>
                    <option value="Iuran Kebersihan" data-nominal="50000">🧹 Iuran Kebersihan (Rp 50.000)</option>
                    <option value="Iuran Keamanan" data-nominal="30000">🛡️ Iuran Keamanan (Rp 30.000)</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Bulan <span class="required">*</span></label>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tahun <span class="required">*</span></label>
                <select name="tahun" class="form-control" required>
                    <option value="">Pilih Tahun</option>
                    @for($i = date('Y')-1; $i <= date('Y')+2; $i++)
                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jumlah (Rp) <span class="required">*</span></label>
                <input type="number" name="nominal" id="nominalInput" class="form-control" value="100000" required>
            </div>
            <div class="form-group">
                <label>Tanggal Bayar <span class="required">*</span></label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <!-- STATUS PEMBAYARAN -->
        <div class="form-group">
            <label>Status Pembayaran</label>
            <select name="status" class="form-control" disabled>
                <option value="belum">⏳ Menunggu Verifikasi</option>
            </select>
            <input type="hidden" name="status" value="belum">
            <div class="status-hint">
                <i class="fas fa-info-circle"></i> 
                <strong>Perhatian:</strong> Pembayaran akan diverifikasi oleh admin terlebih dahulu. 
                Status akan berubah menjadi LUNAS setelah admin menyetujui bukti pembayaran.
            </div>
        </div>

        <!-- BUKTI PEMBAYARAN -->
        <div class="form-group">
            <label>Bukti Pembayaran</label>
            <div class="upload-area" onclick="document.getElementById('bukti_input').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Klik untuk upload bukti pembayaran</p>
                <p style="font-size: 10px;">JPG, PNG (Max 2MB)</p>
            </div>
            <input type="file" name="bukti_pembayaran" id="bukti_input" style="display: none;" accept="image/*">
            <span id="file-name" style="font-size: 12px; color: #64748b; margin-top: 8px; display: block;"></span>
        </div>

        <div class="form-group">
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('iuran.index') }}" class="btn-cancel">Kembali</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('jenisIuranSelect').addEventListener('change', function() {
        var nominal = this.options[this.selectedIndex].getAttribute('data-nominal');
        if (nominal) document.getElementById('nominalInput').value = nominal;
    });
    document.getElementById('bukti_input').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name;
        if (fileName) document.getElementById('file-name').innerHTML = '<i class="fas fa-check-circle"></i> ' + fileName;
    });
</script>
@endsection