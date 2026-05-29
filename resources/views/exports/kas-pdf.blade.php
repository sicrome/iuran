<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Buku Kas</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { background: #f0f0f0; padding: 10px; text-align: center; width: 30%; border-radius: 5px; }
        .stat-value { font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUKU KAS RT</h1>
        <p>Periode: {{ date('F Y') }}</p>
        <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pemasukan</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pengeluaran</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            <div class="stat-label">Saldo Akhir</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Warga</th>
                <th>Keterangan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $saldoSementara = 0; @endphp
            @foreach($transaksi as $index => $item)
            @php
                if ($item->jenis == 'pemasukan') {
                    $saldoSementara += $item->nominal;
                    $pemasukanTampil = $item->nominal;
                    $pengeluaranTampil = 0;
                } else {
                    $saldoSementara -= $item->nominal;
                    $pemasukanTampil = 0;
                    $pengeluaranTampil = $item->nominal;
                }
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td class="text-right">{{ $pemasukanTampil > 0 ? 'Rp ' . number_format($pemasukanTampil, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $pengeluaranTampil > 0 ? 'Rp ' . number_format($pengeluaranTampil, 0, ',', '.') : '-' }}</td>
                <td class="text-right">Rp {{ number_format($saldoSementara, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }} | Sistem Informasi Kas RT
    </div>
</body>
</html>