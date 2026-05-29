<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; padding: 0; font-size: 18px; }
        .header p { margin: 5px 0; font-size: 12px; color: #666; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { background: #f0f0f0; padding: 10px; text-align: center; width: 30%; border-radius: 5px; }
        .stat-value { font-size: 16px; font-weight: bold; }
        .stat-label { font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; font-size: 11px; }
        td { font-size: 10px; }
        .text-right { text-align: right; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #999; }
        .badge-pemasukan { color: #10b981; }
        .badge-pengeluaran { color: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN KAS RT</h1>
        <p>Periode: {{ date('F Y') }}</p>
        <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pemasukan</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pengeluaran</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            <div class="stat-label">Saldo Kas</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Warga</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->jenis == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }} | Sistem Informasi Kas RT
    </div>
</body>
</html>