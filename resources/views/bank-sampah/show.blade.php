@extends('layouts.app')

@section('title', 'Detail Nasabah - Bank Sampah')
@section('page-title', 'Detail Nasabah Bank Sampah')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0" style="border-radius: 16px 16px 0 0; padding: 20px 24px;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-user text-success me-2"></i>Detail Nasabah</h5>
            <div>
                <a href="{{ route('bank-sampah.edit', $bankSampah) }}" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{ route('bank-sampah.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td style="width: 150px;"><strong>Kode Nasabah</strong></td><td>: <span class="badge bg-secondary">{{ $bankSampah->kode_nasabah }}</span></td></tr>
                    <tr><td><strong>Nama Nasabah</strong></td><td>: {{ $bankSampah->nama_nasabah }}</td></tr>
                    <tr><td><strong>NIK</strong></td><td>: {{ $bankSampah->nik ?? '-' }}</td></tr>
                    <tr><td><strong>Alamat</strong></td><td>: {{ $bankSampah->alamat ?? '-' }}</td></tr>
                    <tr><td><strong>No. HP</strong></td><td>: {{ $bankSampah->no_hp ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td style="width: 150px;"><strong>Jenis Sampah</strong></td><td>: {{ $bankSampah->jenis_sampah }}</td></tr>
                    <tr><td><strong>Berat Sampah</strong></td><td>: {{ number_format($bankSampah->berat_sampah, 2) }} kg</td></tr>
                    <tr><td><strong>Harga per Kg</strong></td><td>: Rp {{ number_format($bankSampah->harga_per_kg, 0, ',', '.') }}</td></tr>
                    <tr><td><strong>Saldo Tabungan</strong></td><td>: Rp {{ number_format($bankSampah->saldo_tabungan, 0, ',', '.') }}</td></tr>
                    <tr><td><strong>Status</strong></td><td>: <span class="badge bg-success">{{ $bankSampah->status }}</span></td></tr>
                    <tr><td><strong>Tanggal Setoran</strong></td><td>: {{ $bankSampah->tanggal_setoran ? \Carbon\Carbon::parse($bankSampah->tanggal_setoran)->format('d/m/Y') : '-' }}</td></tr>
                </table>
            </div>
        </div>
        @if($bankSampah->keterangan)
        <div class="mt-3 p-3 bg-light rounded">
            <strong>Keterangan:</strong><br>{{ $bankSampah->keterangan }}
        </div>
        @endif
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Riwayat Penarikan</h5>
            @if($bankSampah->saldo_tabungan > 0)
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTarik">Tarik Dana</button>
            @endif
        </div>

        <div class="mt-3">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jumlah (Rp)</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bankSampah->withdrawals()->latest()->get() as $w)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>Rp {{ number_format($w->amount, 0, ',', '.') }}</td>
                            <td>{{ $w->tanggal_penarikan ? \Carbon\Carbon::parse($w->tanggal_penarikan)->format('d/m/Y') : $w->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-muted">Belum ada penarikan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tarik Dana -->
        <div class="modal fade" id="modalTarik" tabindex="-1" aria-labelledby="modalTarikLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('bank-sampah.tarik', $bankSampah) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTarikLabel">Tarik Dana dari {{ $bankSampah->nama_nasabah }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Saldo tersedia</label>
                                <div><strong>Rp {{ number_format($bankSampah->saldo_tabungan, 0, ',', '.') }}</strong></div>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah yang ditarik (kosong = tarik semua)</label>
                                <input type="number" step="0.01" min="0" max="{{ $bankSampah->saldo_tabungan }}" name="amount" id="amount" class="form-control" placeholder="Masukkan jumlah penarikan" />
                            </div>
                            <div class="form-text">Biarkan kosong untuk menarik seluruh saldo.</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="btnTarikSemua" class="btn btn-outline-danger">Tarik Semua</button>
                            <button type="submit" class="btn btn-danger">Proses Tarik</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            (function(){
                const btnAll = document.getElementById('btnTarikSemua');
                const amountInput = document.getElementById('amount');
                if(btnAll && amountInput){
                    btnAll.addEventListener('click', function(){
                        // clear the input to indicate full withdrawal (server treats empty as full)
                        amountInput.value = '';
                        // submit the form
                        amountInput.closest('form').submit();
                    });
                }
            })();
        </script>
    </div>
</div>
@endsection
