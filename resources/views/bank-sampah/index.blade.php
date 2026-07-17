@extends('layouts.app')

@section('title', 'Bank Sampah - Kas RT')
@section('page-title', 'Bank Sampah')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #10b981, #059669);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 28px; font-weight: 800;">{{ $totalNasabah }}</div>
                        <div style="font-size: 12px; opacity: 0.8;">Total Nasabah</div>
                    </div>
                    <i class="fas fa-users" style="font-size: 36px; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #3b82f6, #2563eb);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 28px; font-weight: 800;">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</div>
                        <div style="font-size: 12px; opacity: 0.8;">Total Saldo Tabungan</div>
                    </div>
                    <i class="fas fa-wallet" style="font-size: 36px; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 28px; font-weight: 800;">{{ number_format($totalBerat, 2) }} kg</div>
                        <div style="font-size: 12px; opacity: 0.8;">Total Berat Sampah</div>
                    </div>
                    <i class="fas fa-weight-scale" style="font-size: 36px; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #ef4444, #dc2626);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 28px; font-weight: 800;">Rp {{ number_format($totalPenarikan, 0, ',', '.') }}</div>
                        <div style="font-size: 12px; opacity: 0.8;">Total Penarikan Dana</div>
                    </div>
                    <i class="fas fa-hand-holding-dollar" style="font-size: 36px; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0" style="border-radius: 16px 16px 0 0; padding: 20px 24px;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-recycle text-success me-2"></i>Data Bank Sampah</h5>
            <a href="{{ route('bank-sampah.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Nasabah</a>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Nasabah</th>
                        <th>Jenis Sampah</th>
                        <th>Berat (kg)</th>
                        <th>Saldo</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bankSampahs as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary">{{ $item->kode_nasabah }}</span></td>
                        <td>{{ $item->nama_nasabah }}</td>
                        <td>{{ $item->jenis_sampah }}</td>
                        <td>{{ number_format($item->berat_sampah, 2) }}</td>
                        <td>Rp {{ number_format($item->saldo_tabungan, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusClass = match($item->status) {
                                    'Tersimpan' => 'success',
                                    'Menunggu Timbang' => 'warning',
                                    'Sudah Diambil' => 'info',
                                    'Ditarik' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">{{ $item->status }}</span>
                        </td>
                        <td>{{ $item->tanggal_setoran ? \Carbon\Carbon::parse($item->tanggal_setoran)->format('d/m/Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('bank-sampah.show', $item) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('bank-sampah.edit', $item) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                            @if($item->saldo_tabungan > 0 && $item->status !== 'Ditarik')
                            <form action="{{ route('bank-sampah.tarik', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Proses penarikan dana untuk {{ $item->nama_nasabah }}?')">
                                @csrf
                                <button class="btn btn-sm btn-danger" title="Tarik Dana"><i class="fas fa-hand-holding-dollar"></i></button>
                            </form>
                            @endif
                            <form action="{{ route('bank-sampah.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data bank sampah</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $bankSampahs->links() }}
        </div>
    </div>
</div>
@endsection