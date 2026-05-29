<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Iuran Warga</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { background: #f0f0f0; padding: 10px; text-align: center; width: 45%; border-radius: 5px; }
        .stat-value { font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .badge-lunas { color: #10b981; }
        .badge-belum { color: #ef4444; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN IURAN WARGA</h1>
        <p>Periode: {{ date('F Y') }}</p>
        <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
            <div class="stat-label">Total Lunas</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($totalBelum, 0, ',', '.') }}</div>
            <div class="stat-label">Total Belum Bayar</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Warga</th>
                <th>Bulan/Tahun</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($iuran as $index => $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->bulan_tahun }}</td>
                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ $item->status == 'lunas' ? 'Lunas' : 'Belum Bayar' }}</td>
                <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }} | Sistem Informasi Kas RT
    </div>
</body>
</html>