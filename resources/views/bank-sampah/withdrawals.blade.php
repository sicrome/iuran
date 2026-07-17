@extends('layouts.app')

@section('title', 'Riwayat Penarikan - Bank Sampah')
@section('page-title', 'Riwayat Penarikan Bank Sampah')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-header bg-white border-0" style="padding:18px 22px;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-hand-holding-dollar text-danger me-2"></i>Riwayat Penarikan</h5>
            <div>
                <a href="{{ route('bank-sampah.withdrawals.export') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-file-csv"></i> Export CSV</a>
                <a href="{{ route('bank-sampah.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Nasabah</th>
                        <th>Nama</th>
                        <th>Jumlah (Rp)</th>
                        <th>Tanggal</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $w)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $w->bankSampah->kode_nasabah ?? '-' }}</td>
                        <td>{{ $w->bankSampah->nama_nasabah ?? '-' }}</td>
                        <td>Rp {{ number_format($w->amount, 0, ',', '.') }}</td>
                        <td>{{ $w->tanggal_penarikan ? \Carbon\Carbon::parse($w->tanggal_penarikan)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $w->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada penarikan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-2">{{ $withdrawals->links() }}</div>
    </div>
</div>
@endsection
