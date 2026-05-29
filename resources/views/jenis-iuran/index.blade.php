@extends('layouts.app')

@section('title', 'Buat Iuran Baru - Kas RT')
@section('page-title', 'Kelola Jenis Iuran')

@section('content')
<style>
    .page-header {
        margin-bottom: 25px;
    }
    .page-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }
    .page-header p {
        font-size: 13px;
        color: #64748b;
    }

    /* Card */
    .card-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    /* Header Actions */
    .header-actions {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .btn-tambah {
        background: #10b981;
        color: white;
        padding: 8px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-tambah:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Search Box */
    .search-box {
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 8px 16px;
        width: 280px;
    }
    .search-box i {
        color: #94a3b8;
        margin-right: 10px;
    }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 13px;
    }

    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background: #f8fafc;
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Badge Status */
    .badge-aktif {
        background: #d1fae5;
        color: #10b981;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-nonaktif {
        background: #fee2e2;
        color: #ef4444;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    /* Icon Box */
    .icon-box {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    /* Buttons Action */
    .btn-edit {
        background: #f59e0b;
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 11px;
        display: inline-block;
        margin-right: 5px;
        transition: all 0.2s;
    }
    .btn-edit:hover {
        background: #d97706;
    }
    .btn-delete {
        background: #ef4444;
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 11px;
        display: inline-block;
        transition: all 0.2s;
    }
    .btn-delete:hover {
        background: #dc2626;
    }

    /* Pagination */
    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
    }
    .pagination {
        display: flex;
        gap: 8px;
    }
    .pagination a, .pagination span {
        padding: 6px 12px;
        background: #f1f5f9;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        font-size: 12px;
    }
    .pagination .active span {
        background: #3b82f6;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-actions {
            flex-direction: column;
            align-items: stretch;
        }
        .search-box {
            width: 100%;
        }
        .data-table th, .data-table td {
            padding: 10px 8px;
            font-size: 11px;
        }
        .btn-edit, .btn-delete {
            padding: 3px 8px;
            font-size: 10px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h2>Buat Iuran Baru</h2>
        <p>Kelola jenis-jenis iuran yang tersedia</p>
    </div>
</div>

<div class="card-table">
    <div class="header-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari jenis iuran..." onkeyup="filterTable()">
        </div>
        <a href="{{ route('jenis-iuran.create') }}" class="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Jenis Iuran
        </a>
    </div>

    <div class="table-responsive" style="overflow-x: auto;">
        <table class="data-table" id="jenisIuranTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Icon</th>
                    <th>Nama Jenis Iuran</th>
                    <th>Nominal Default</th>
                    <th>Denda/Hari</th>
                    <th>Batas Tgl</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisIuran as $item)
                <tr>
                    <td style="width: 50px;">{{ $loop->iteration }}</td>
                    <td style="width: 60px;"><div class="icon-box">{{ $item->icon ?? '💰' }}</div></td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>Rp {{ number_format($item->nominal_default, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->denda_per_hari, 0, ',', '.') }}</td>
                    <td>Tanggal {{ $item->batas_tanggal }}</td>
                    <td>
                        <span class="badge-{{ $item->status }}">
                            {{ $item->status == 'aktif' ? '✅ Aktif' : '❌ Nonaktif' }}
                        </span>
                    </td>
                    <td style="width: 130px;">
                        <a href="{{ route('jenis-iuran.edit', $item->id) }}" class="btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('jenis-iuran.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus jenis iuran ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 50px;">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                        <p style="margin-top: 12px; color: #64748b;">Belum ada jenis iuran</p>
                        <a href="{{ route('jenis-iuran.create') }}" class="btn-tambah" style="margin-top: 15px; display: inline-block;">
                            <i class="fas fa-plus"></i> Buat Jenis Iuran Baru
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jenisIuran->hasPages())
    <div class="pagination-container">
        <div class="pagination">
            {{ $jenisIuran->links() }}
        </div>
    </div>
    @endif
</div>

<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('jenisIuranTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0) {
                const nameCell = cells[2];
                if (nameCell) {
                    const textValue = nameCell.textContent || nameCell.innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    }
</script>
@endsection