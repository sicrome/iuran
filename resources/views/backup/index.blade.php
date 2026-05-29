@extends('layouts.app')

@section('title', 'Backup Data - Kas RT')
@section('page-title', 'Backup Data')

@section('content')
<style>
    .backup-card {
        background: linear-gradient(135deg, rgba(102,126,234,0.15), rgba(118,75,162,0.15));
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s;
    }
    .backup-card:hover {
        transform: translateY(-5px);
        background: linear-gradient(135deg, rgba(102,126,234,0.25), rgba(118,75,162,0.25));
    }
    .backup-icon {
        font-size: 50px;
        margin-bottom: 15px;
    }
    .backup-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }
    .backup-desc {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 20px;
    }
    .backup-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }
    .btn-backup {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-backup:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    .table-backup {
        width: 100%;
        border-collapse: collapse;
    }
    .table-backup th {
        background: #f8fafc;
        padding: 12px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-backup td {
        padding: 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
    .btn-sm {
        padding: 4px 10px;
        font-size: 11px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin: 0 3px;
    }
    .btn-primary {
        background: #3b82f6;
        color: white;
    }
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    @media (max-width: 600px) {
        .backup-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-header">
    <h2>Backup Data</h2>
    <p>Kelola backup database sistem</p>
</div>

<div class="backup-grid">
    <div class="backup-card">
        <div class="backup-icon">💾</div>
        <div class="backup-title">Backup Database</div>
        <div class="backup-desc">Backup seluruh database ke file SQL</div>
        <form action="{{ route('backup.database') }}" method="POST">
            @csrf
            <button type="submit" class="btn-backup">
                <i class="fas fa-database"></i> Backup Sekarang
            </button>
        </form>
    </div>
</div>

<div class="card" style="background: white; border-radius: 16px; padding: 20px;">
    <div class="card-title" style="font-size: 16px; font-weight: 700; margin-bottom: 15px;">
        <i class="fas fa-history"></i> Riwayat Backup
    </div>
    
    <div class="table-responsive">
        <table class="table-backup">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Ukuran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backupFiles as $index => $file)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ basename($file) }}</td>
                    <td>{{ round($file->getSize() / 1024, 2) }} KB</td>
                    <td>{{ date('d/m/Y H:i:s', $file->getMTime()) }}</td>
                    <td>
                        <a href="{{ route('backup.download', basename($file)) }}" class="btn-sm btn-primary">
                            <i class="fas fa-download"></i> Download
                        </a>
                        <a href="{{ route('backup.delete', basename($file)) }}" class="btn-sm btn-danger" onclick="return confirm('Yakin hapus file ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">
                        <i class="fas fa-inbox" style="font-size: 40px; color: #cbd5e1;"></i>
                        <p style="margin-top: 10px;">Belum ada backup</p>
                        <p style="font-size: 12px; color: #64748b;">Klik tombol "Backup Sekarang" untuk membuat backup pertama</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection