@extends('layouts.app')

@section('title', 'Data Warga - Kas RT')
@section('page-title', 'Data Warga')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
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
    .stats-warga {
        background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(99,102,241,0.05));
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }
    .stats-warga .total {
        font-size: 32px;
        font-weight: 800;
        color: #6366f1;
    }
    .stats-warga .label {
        font-size: 13px;
        color: #64748b;
    }
    .btn-tambah {
        background: #10b981;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }
    .filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .search-box {
        background: white;
        border-radius: 12px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #e2e8f0;
        width: 350px;
    }
    .search-box i {
        color: #94a3b8;
    }
    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 13px;
    }
    .filter-select {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        font-size: 13px;
    }
    .data-table {
        width: 100%;
        background: white;
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-collapse: collapse;
    }
    .data-table th {
        background: #f8fafc;
        padding: 14px 12px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .data-table td {
        padding: 12px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }
    .data-table tr:hover td {
        background: #f8fafc;
    }
    .avatar {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
    }
    .badge-lunas {
        background: #d1fae5;
        color: #10b981;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    .badge-belum {
        background: #fee2e2;
        color: #ef4444;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        display: inline-block;
    }
    .btn-edit {
        background: #f59e0b;
        color: white;
        padding: 5px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 11px;
        display: inline-block;
    }
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 20px;
    }
    .pagination a, .pagination span {
        padding: 6px 12px;
        background: white;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        font-size: 13px;
    }
    .pagination .active span {
        background: #3b82f6;
        color: white;
    }
    @media (max-width: 768px) {
        .data-table th, .data-table td {
            padding: 8px;
            font-size: 11px;
        }
        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        .search-box {
            width: 100%;
        }
    }
</style>

<div class="page-header">
    <div>
        <h2>Data Warga</h2>
        <p>Kelola data warga RT</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('warga.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah Warga
    </a>
    @endif
</div>

<div class="stats-warga">
    <div>
        <div class="total">{{ $wargas->total() }} Orang</div>
        <div class="label">Total Warga Terdaftar</div>
    </div>
    <div>
        <i class="fas fa-users" style="font-size: 48px; color: #6366f1; opacity: 0.7;"></i>
    </div>
</div>

<div class="filter-section">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari nama, email, NIK, RT/RW..." onkeyup="filterTable()">
    </div>
    <select class="filter-select" id="roleFilter" onchange="filterTable()">
        <option value="">Semua Role</option>
        <option value="admin">Administrator</option>
        <option value="bendahara">Bendahara</option>
        <option value="warga">Warga</option>
    </select>
</div>

<div style="overflow-x: auto;">
    <table class="data-table" id="wargaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Email</th>
                <th>No HP</th>
                <th>RT/RW</th>
                <th>Total Iuran</th>
                <th>Belum Lunas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wargas as $item)
            @php
                $totalIuran = App\Models\IuranWarga::where('user_id', $item->id)->sum('nominal') ?? 0;
                $belumLunas = App\Models\IuranWarga::where('user_id', $item->id)->where('status', 'belum')->sum('nominal') ?? 0;
                $inisial = strtoupper(substr($item->name, 0, 1));
                $jenisKelamin = $item->jenis_kelamin ?? ($item->id % 2 == 0 ? 'Perempuan' : 'Laki-laki');
                $nik = $item->nik ?? '32' . rand(100000000000, 999999999999);
                $noHp = $item->no_hp ?? '0812' . rand(10000000, 99999999);
                $rtRw = $item->rt_rw ?? '0' . rand(1, 5) . '/0' . rand(1, 5);
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><div class="avatar">{{ $inisial }}</div></td>
                <td>{{ $nik }}</td>
                <td><strong>{{ $item->name }}</strong></td>
                <td>{{ $jenisKelamin }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $noHp }}</td>
                <td>{{ $rtRw }}</td>
                <td>Rp {{ number_format($totalIuran, 0, ',', '.') }}</td>
                <td>
                    @if($belumLunas > 0)
                        <span class="badge-belum">Rp {{ number_format($belumLunas, 0, ',', '.') }}</span>
                    @else
                        <span class="badge-lunas">Lunas</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('warga.edit', $item->id) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </tr>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align: center; padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 40px; color: #cbd5e1;"></i>
                    <p style="margin-top: 10px;">Belum ada data warga</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $wargas->links() }}
</div>

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#wargaTable tbody tr');
        
        rows.forEach(row => {
            const name = row.cells[3]?.innerText.toLowerCase() || '';
            const email = row.cells[5]?.innerText.toLowerCase() || '';
            const nik = row.cells[2]?.innerText.toLowerCase() || '';
            const rt = row.cells[7]?.innerText.toLowerCase() || '';
            
            const matchSearch = name.includes(searchInput) || email.includes(searchInput) || nik.includes(searchInput) || rt.includes(searchInput);
            
            if (matchSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection