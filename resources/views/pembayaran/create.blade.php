@extends('layouts.app')

@section('title', 'Bayar Iuran - Kas RT')
@section('page-title', 'Bayar Iuran')

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
        background: white;
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
        background: #10b981;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
    }
    .btn-submit:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
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
    .info-note {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 12px;
        color: #92400e;
    }
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .form-card { margin: 0 15px; padding: 20px; }
    }
</style>

<div class="page-header">
    <h2>Bayar Iuran</h2>
    <p>Lakukan pembayaran iuran Anda</p>
</div>

<div class="form-card">
    <div class="form-title">
        <i class="fas fa-hand-holding-usd" style="margin-right: 10px; color: #10b981;"></i> Form Pembayaran Iuran
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

    <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Warga (otomatis dari user login) -->
        <div class="form-group">
            <label>Nama Warga <span class="required">*</span></label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly disabled style="background:#f1f5f9;">
            <small style="font-size: 11px; color: #64748b;">Membayar iuran untuk: <strong>{{ auth()->user()->name }}</strong></small>
        </div>

        <!-- Bulan / Tahun (gabungan) -->
        <div class="form-group">
            <label>Bulan / Tahun <span class="required">*</span></label>
            <select name="bulan_tahun" class="form-control" required>
                <option value="">Pilih Bulan/Tahun</option>
                @php
                    $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $tahun = date('Y');
                    for ($i = 0; $i < 12; $i++) {
                        $bulan = $bulanList[$i];
                        echo "<option value='$bulan $tahun'>$bulan $tahun</option>";
                    }
                @endphp
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jenis Iuran <span class="required">*</span></label>
                <select name="jenis_iuran" id="jenisIuran" class="form-control" required>
                    <option value="">Pilih Jenis Iuran</option>
                    <option value="Iuran Warga" data-nominal="100000">Iuran Warga (Rp 100.000)</option>
                    <option value="Iuran Kebersihan" data-nominal="50000">Iuran Kebersihan (Rp 50.000)</option>
                    <option value="Iuran Keamanan" data-nominal="30000">Iuran Keamanan (Rp 30.000)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp) <span class="required">*</span></label>
                <input type="number" name="nominal" id="nominalInput" class="form-control" placeholder="Contoh: 50000" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Metode Pembayaran <span class="required">*</span></label>
                <select name="metode" class="form-control" required>
                    <option value="">Pilih Metode</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Bayar <span class="required">*</span></label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Bukti Pembayaran <span class="required">*</span></label>
            <div class="upload-area" onclick="document.getElementById('bukti_input').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Klik untuk upload bukti pembayaran</p>
                <p style="font-size: 10px;">JPG, PNG, PDF (Max 2MB)</p>
            </div>
            <input type="file" name="bukti_pembayaran" id="bukti_input" style="display: none;" accept="image/*,application/pdf" required>
            <span id="file-name" style="font-size: 12px; color: #64748b; margin-top: 8px; display: block;"></span>
            <small style="font-size: 11px; color: #64748b;">Upload bukti transfer/foto struk (JPG, PNG, PDF max 2MB)</small>
        </div>

        <div class="form-group">
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
        </div>

        <!-- Informasi Verifikasi -->
        <div class="info-note">
            <i class="fas fa-info-circle"></i> 
            <strong>Perhatian:</strong> Setelah melakukan pembayaran, bukti akan diverifikasi oleh Admin/Bendahara. 
            Status akan berubah menjadi "Lunas" setelah diverifikasi.
        </div>

        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn-cancel">Kembali</a>
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Bayar Sekarang</button>
        </div>
    </form>
</div>

<script>
    // Auto update nominal berdasarkan jenis iuran
    document.getElementById('jenisIuran').addEventListener('change', function() {
        var nominal = this.options[this.selectedIndex].getAttribute('data-nominal');
        if (nominal) {
            document.getElementById('nominalInput').value = nominal;
        }
    });

    // Tampilkan nama file yang diupload
    document.getElementById('bukti_input').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name;
        if (fileName) {
            document.getElementById('file-name').innerHTML = '<i class="fas fa-check-circle" style="color: #10b981;"></i> ' + fileName;
        }
    });
</script>
@endsection