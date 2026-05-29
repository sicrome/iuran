<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kas RT')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; font-size: 13px; }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #1e293b;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            overflow-y: auto;
            color: white;
        }
        .sidebar-header { padding: 25px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h3 { font-size: 18px; font-weight: 700; }
        .sidebar-header p { font-size: 11px; color: #94a3b8; margin-top: 5px; }
        .sidebar-menu { padding: 20px; }
        .menu-group { margin-bottom: 25px; }
        .menu-group-title {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            padding-left: 5px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin: 3px 0;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            gap: 12px;
            font-size: 13px;
            transition: all 0.2s;
        }
        .menu-item i { width: 22px; font-size: 14px; }
        .menu-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .menu-item.active { background: #3b82f6; color: white; }

        .main-content { margin-left: 280px; min-height: 100vh; background: #f0f2f5; }
        .top-navbar {
            background: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .page-title { font-size: 18px; font-weight: 700; color: #1e293b; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-name { font-weight: 600; color: #1e293b; font-size: 14px; }
        .user-role { font-size: 11px; color: #64748b; }
        .logout-btn { background: #ef4444; color: white; border: none; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-size: 12px; }
        .content-wrapper { padding: 25px; }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-header h3, .sidebar-header p, .menu-group-title, .menu-item span { display: none; }
            .main-content { margin-left: 70px; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>🏘️ KAS RT</h3>
            <p>Keuangan RT</p>
        </div>

        <div class="sidebar-menu">
            @if(auth()->user()->isWarga())
                <!-- ========== MENU KHUSUS WARGA ========== -->
                <div class="menu-group">
                    <div class="menu-group-title">IURAN</div>
                    <a href="{{ route('pembayaran.create') }}" class="menu-item">
                        <i class="fas fa-upload"></i><span>Bayar Iuran</span>
                    </a>
                    <a href="{{ route('pembayaran.index') }}" class="menu-item">
                        <i class="fas fa-history"></i><span>Riwayat Pembayaran</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">PROFIL</div>
                    <a href="{{ route('profile.edit') }}" class="menu-item">
                        <i class="fas fa-user-circle"></i><span>Profil Saya</span>
                    </a>
                    <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Keluar</span>
                    </a>
                </div>

            @else
                <!-- ========== MENU ADMIN & BENDAHARA (LENGKAP) ========== -->
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>

                <!-- IURAN GROUP -->
                <div class="menu-group">
                    <div class="menu-group-title">IURAN</div>
                    <a href="{{ route('iuran.index') }}" class="menu-item">
                        <i class="fas fa-database"></i><span>Data Iuran</span>
                    </a>
                    <a href="{{ route('iuran.create') }}" class="menu-item">
                        <i class="fas fa-plus-circle"></i><span>Tambah Iuran</span>
                    </a>
                    <a href="{{ route('pembayaran.index') }}" class="menu-item">
                        <i class="fas fa-check-circle"></i><span>Verifikasi Pembayaran</span>
                    </a>
                </div>

                <!-- MASTER DATA GROUP -->
                <div class="menu-group">
                    <div class="menu-group-title">MASTER DATA</div>
                    <a href="{{ route('warga.index') }}" class="menu-item">
                        <i class="fas fa-users"></i><span>Warga</span>
                    </a>
                </div>

                <!-- LAPORAN GROUP -->
                <div class="menu-group">
                    <div class="menu-group-title">LAPORAN</div>
                    <a href="{{ route('laporan.keuangan') }}" class="menu-item">
                        <i class="fas fa-chart-line"></i><span>Laporan Keuangan</span>
                    </a>
                    <a href="{{ route('laporan.iuran') }}" class="menu-item">
                        <i class="fas fa-file-invoice"></i><span>Laporan Iuran</span>
                    </a>
                    <a href="{{ route('export.keuangan') }}" class="menu-item">
                        <i class="fas fa-download"></i><span>Export Laporan</span>
                    </a>
                </div>

                <!-- PENGATURAN GROUP -->
                <div class="menu-group">
                    <div class="menu-group-title">PENGATURAN</div>
                    <a href="{{ route('jenis-iuran.index') }}" class="menu-item">
                        <i class="fas fa-hand-holding-usd"></i><span>Buat Iuran Baru</span>
                    </a>
                    <a href="{{ route('backup.index') }}" class="menu-item">
                        <i class="fas fa-database"></i><span>Backup</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="menu-item">
                        <i class="fas fa-user-circle"></i><span>Profil Saya</span>
                    </a>
                    <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Keluar</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="user-info">
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role->display_name ?? 'User' }}</div>
                </div>
                <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </div>
        </div>
        <div class="content-wrapper">
            @if(session('success'))
                <div style="background:#d4edda; color:#155724; padding:12px; border-radius:10px; margin-bottom:20px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:10px; margin-bottom:20px;">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</body>
</html>