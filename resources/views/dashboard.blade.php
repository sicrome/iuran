@extends('layouts.app')

@section('title', 'Dashboard - Kas RT')
@section('page-title', 'Dashboard')

@section('content')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 20px;
        padding: 20px 25px;
        margin-bottom: 25px;
        color: white;
    }
    .welcome-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 3px; }
    .welcome-card p { font-size: 12px; opacity: 0.9; }

    /* SIMPLE NOTIFICATION */
    .notif-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }
    .notif-card {
        background: white;
        border-radius: 14px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-left: 4px solid;
    }
    .notif-danger { border-left-color: #ef4444; }
    .notif-warning { border-left-color: #f59e0b; }
    .notif-info { border-left-color: #3b82f6; }
    .notif-value { font-size: 28px; font-weight: 800; }
    .notif-label { font-size: 11px; color: #64748b; margin-top: 3px; }
    .notif-icon { font-size: 28px; opacity: 0.7; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .stat-value { font-size: 22px; font-weight: 800; color: #1e293b; }
    .stat-label { font-size: 11px; color: #64748b; margin-top: 4px; }

    .progress-card {
        background: white;
        border-radius: 14px;
        padding: 15px 20px;
        margin-bottom: 25px;
    }
    .progress-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        margin: 10px 0;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #059669);
        border-radius: 4px;
        transition: width 0.5s;
    }
    .two-col-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }
    .card {
        background: white;
        border-radius: 14px;
        padding: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .card-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
    }
    .chart-container { height: 200px; }
    .kategori-item { margin-bottom: 12px; }
    .kategori-header {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 4px;
    }
    .kategori-bar {
        height: 6px;
        background: #e2e8f0;
        border-radius: 3px;
    }
    .kategori-fill { height: 100%; border-radius: 3px; }

    @media (max-width: 800px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .two-col-grid { grid-template-columns: 1fr; }
        .notif-grid { grid-template-columns: 1fr; }
    }
</style>

@php
    $totalPemasukan = App\Models\Kas::where('jenis', 'pemasukan')->sum('nominal') ?? 0;
    $totalPengeluaran = App\Models\Kas::where('jenis', 'pengeluaran')->sum('nominal') ?? 0;
    $saldo = $totalPemasukan - $totalPengeluaran;
    $totalWarga = App\Models\User::where('role_id', 3)->count() ?? 0;
    
    // Data iuran bulan ini
    $bulanIni = date('F Y');
    $totalTagihan = $totalWarga * 100000;
    $totalTerkumpul = App\Models\IuranWarga::where('status', 'lunas')->sum('nominal') ?? 0;
    $persentase = $totalTagihan > 0 ? round(($totalTerkumpul / $totalTagihan) * 100) : 0;
    
    // Belum Lunas (bukan Sudah Bayar)
    $belumLunas = App\Models\IuranWarga::where('status', 'belum')->count();
    $menungguVerifikasi = App\Models\IuranWarga::where('verifikasi_status', 'pending')->count();
    
    // Grafik 6 bulan
    $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    $pemasukanData = [];
    $pengeluaranData = [];
    for ($i = 5; $i >= 0; $i--) {
        $bulanKe = 5 - $i;
        $pemasukanData[$bulanKe] = App\Models\Kas::where('jenis', 'pemasukan')
            ->whereMonth('tanggal', date('m', strtotime("-$i months")))
            ->whereYear('tanggal', date('Y', strtotime("-$i months")))
            ->sum('nominal') ?? 0;
        $pengeluaranData[$bulanKe] = App\Models\Kas::where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', date('m', strtotime("-$i months")))
            ->whereYear('tanggal', date('Y', strtotime("-$i months")))
            ->sum('nominal') ?? 0;
    }
    
    // Kategori pengeluaran
    $kategoriPengeluaran = App\Models\Kas::where('jenis', 'pengeluaran')
        ->select('keterangan', \Illuminate\Support\Facades\DB::raw('SUM(nominal) as total'))
        ->groupBy('keterangan')
        ->get();
@endphp

<div>
    <!-- Welcome -->
    <div class="welcome-card">
        <h2>Halo, {{ auth()->user()->name }}!</h2>
        <p>Kelola keuangan RT dengan mudah dan transparan</p>
    </div>

    <!-- Simple Notifications -->
    <div class="notif-grid">
        <div class="notif-card notif-danger">
            <div>
                <div class="notif-value">{{ $belumLunas }}</div>
                <div class="notif-label">Belum Lunas</div>
            </div>
            <div class="notif-icon">⚠️</div>
        </div>
        <div class="notif-card notif-warning">
            <div>
                <div class="notif-value">{{ $menungguVerifikasi }}</div>
                <div class="notif-label">Menunggu Verifikasi</div>
            </div>
            <div class="notif-icon">🔄</div>
        </div>
    </div>

    <!-- Progress Iuran -->
    <div class="progress-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-weight: 700;">📊 Iuran Bulan {{ date('F Y') }}</div>
                <div style="font-size: 12px; color: #64748b;">Target: Rp {{ number_format($totalTagihan,0,',','.') }}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 20px; font-weight: 800; color: #10b981;">{{ $persentase }}%</div>
            </div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $persentase }}%;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 11px; margin-top: 8px;">
            <span>💰 Terkumpul: Rp {{ number_format($totalTerkumpul,0,',','.') }}</span>
            <span>👥 {{ round($totalTerkumpul/100000) }}/{{ $totalWarga }} Warga</span>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card"><div class="stat-value">Rp {{ number_format($totalPemasukan,0,',','.') }}</div><div class="stat-label">TOTAL PEMASUKAN</div></div>
        <div class="stat-card"><div class="stat-value">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div><div class="stat-label">TOTAL PENGELUARAN</div></div>
        <div class="stat-card"><div class="stat-value">Rp {{ number_format($saldo,0,',','.') }}</div><div class="stat-label">SALDO KAS</div></div>
        <div class="stat-card"><div class="stat-value">{{ number_format($totalWarga) }}</div><div class="stat-label">TOTAL WARGA</div></div>
    </div>

    <!-- Charts -->
    <div class="two-col-grid">
        <div class="card">
            <div class="card-title">📊 Grafik Kas Bulanan</div>
            <div class="chart-container"><canvas id="kasChart"></canvas></div>
        </div>
        <div class="card">
            <div class="card-title">📊 Pengeluaran per Kategori</div>
            @forelse($kategoriPengeluaran as $item)
            <div class="kategori-item">
                <div class="kategori-header">
                    <span>{{ $item->keterangan }}</span>
                    <span>Rp {{ number_format($item->total,0,',','.') }}</span>
                </div>
                <div class="kategori-bar">
                    <div class="kategori-fill" style="width: {{ ($item->total / max($totalPengeluaran,1)) * 100 }}%; background: #3b82f6;"></div>
                </div>
            </div>
            @empty
            <p style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada data pengeluaran</p>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('kasChart'), {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [
                { label: 'Pemasukan', data: @json($pemasukanData), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.05)', fill: true, tension: 0.4, borderWidth: 2 },
                { label: 'Pengeluaran', data: @json($pengeluaranData), borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.05)', fill: true, tension: 0.4, borderWidth: 2 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } } }
    });
</script>
@endsection