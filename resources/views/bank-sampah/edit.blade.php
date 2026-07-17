@extends('layouts.app')

@section('title', 'Edit Nasabah - Bank Sampah')
@section('page-title', 'Edit Nasabah Bank Sampah')

@section('content')
<style>
    .calculation-box { background: linear-gradient(135deg, #e8f7ef, #f8fffb); border: 1px solid #ccebd9; border-radius: 14px; padding: 18px; }
    .calculation-box .total-value { color: #157347; font-size: 25px; font-weight: 800; }
</style>
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0" style="border-radius: 16px 16px 0 0; padding: 20px 24px;">
        <h5 class="mb-0 fw-bold"><i class="fas fa-edit text-warning me-2"></i>Form Edit Nasabah</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('bank-sampah.update', $bankSampah) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Pilih Warga (opsional)</label>
                    <select id="warga_select" name="warga_id" class="form-control">
                        <option value="">-- Pilih warga --</option>
                        @foreach($wargas as $w)
                        <option value="{{ $w->id }}" data-nik="{{ $w->nik }}" data-alamat="{{ e($w->alamat) }}" data-nohp="{{ $w->no_hp }}" {{ isset($bankSampah->warga_id) && $bankSampah->warga_id == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Nasabah <span class="text-danger">*</span></label>
                    <input type="text" id="nama_nasabah" name="nama_nasabah" class="form-control" value="{{ old('nama_nasabah', $bankSampah->nama_nasabah) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIK</label>
                    <input type="text" id="nik" name="nik" class="form-control" value="{{ old('nik', $bankSampah->nik) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="2">{{ old('alamat', $bankSampah->alamat) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" value="{{ old('no_hp', $bankSampah->no_hp) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis Sampah <span class="text-danger">*</span></label>
                    <select id="jenis_sampah" name="jenis_sampah" class="form-control" required>
                        @foreach(['Plastik','Kertas','Logam','Organik','Kaca','Elektronik'] as $jns)
                        <option value="{{ $jns }}" {{ old('jenis_sampah', $bankSampah->jenis_sampah) == $jns ? 'selected' : '' }}>{{ $jns }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Berat Sampah (kg) <span class="text-danger">*</span></label>
                    <input id="berat_sampah" type="number" step="0.01" min="0" name="berat_sampah" class="form-control" value="{{ old('berat_sampah', $bankSampah->berat_sampah) }}" required>
                </div>
                <div class="col-md-4"><div class="calculation-box h-100">
                    <small class="text-muted d-block mb-1">Harga otomatis per kg</small>
                    <div id="harga_per_kg" class="fw-bold">Rp 0</div>
                    <small class="text-muted">Sesuai jenis sampah</small>
                </div></div>
                <div class="col-12"><div class="calculation-box d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div><small class="text-muted d-block">Estimasi total saldo</small><div id="saldo_tabungan" class="total-value">Rp 0</div></div>
                    <div class="text-muted small"><i class="fas fa-calculator me-1"></i><span id="rumus_total">0 kg × Rp 0</span></div>
                </div></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control" required>
                        @foreach(['Tersimpan','Menunggu Timbang','Sudah Diambil','Ditarik'] as $st)
                        <option value="{{ $st }}" {{ old('status', $bankSampah->status) == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Petugas</label>
                    <input type="text" name="petugas" class="form-control" value="{{ old('petugas', $bankSampah->petugas) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Setoran</label>
                    <input type="date" name="tanggal_setoran" class="form-control" value="{{ old('tanggal_setoran', $bankSampah->tanggal_setoran ? \Carbon\Carbon::parse($bankSampah->tanggal_setoran)->format('Y-m-d') : date('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $bankSampah->keterangan) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('bank-sampah.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<script>
    const berat = document.getElementById('berat_sampah');
    const jenis = document.getElementById('jenis_sampah');
    const harga = document.getElementById('harga_per_kg');
    const total = document.getElementById('saldo_tabungan');
    const rumus = document.getElementById('rumus_total');
    const daftarHarga = @json($hargaSampah);
    const hitungTotal = () => { const hargaKg = daftarHarga[jenis.value] || 0; const beratKg = parseFloat(berat.value) || 0; harga.textContent = 'Rp ' + hargaKg.toLocaleString('id-ID'); total.textContent = 'Rp ' + (beratKg * hargaKg).toLocaleString('id-ID'); rumus.textContent = beratKg.toLocaleString('id-ID') + ' kg × Rp ' + hargaKg.toLocaleString('id-ID'); };
    berat.addEventListener('input', hitungTotal); jenis.addEventListener('change', hitungTotal); hitungTotal();
    // warga select autofill
    const wargaSelect = document.getElementById('warga_select');
    if (wargaSelect) {
        wargaSelect.addEventListener('change', function(){
            const opt = this.options[this.selectedIndex];
            const nama = opt.textContent || '';
            const nikv = opt.dataset.nik || '';
            const alamatv = opt.dataset.alamat || '';
            const nohpv = opt.dataset.nohp || '';
            if(document.getElementById('nama_nasabah')) document.getElementById('nama_nasabah').value = nama || '';
            if(document.getElementById('nik')) document.getElementById('nik').value = nikv || '';
            if(document.getElementById('alamat')) document.getElementById('alamat').value = alamatv || '';
            if(document.getElementById('no_hp')) document.getElementById('no_hp').value = nohpv || '';
        });
    }
</script>
@endsection
