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
        html, body { height: 100%; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; font-size: 13px; overflow-x: hidden; overflow-y: auto; color: #1e293b; }

        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
            overflow-x: hidden;
            color: white;
        }
        .sidebar-header { padding: 25px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h3 { font-size: 18px; font-weight: 700; }
        .sidebar-header p { font-size: 11px; color: #94a3b8; margin-top: 5px; }
        .sidebar-menu { padding: 20px 20px 40px; }
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
            box-shadow: 0 1px 3px rgba(15,23,42,0.06);
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .page-title { font-size: 18px; font-weight: 700; color: #1e293b; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-name { font-weight: 600; color: #1e293b; font-size: 14px; }
        .user-role { font-size: 11px; color: #64748b; }
        .logout-btn { background: #ef4444; color: white; border: none; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-size: 12px; }
        .content-wrapper { padding: 28px; max-width: 1680px; margin: 0 auto; }
        .sidebar-toggle { display: none; border: 0; width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #2563eb; cursor: pointer; }
        .flash-message { padding: 12px 14px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; }

        @media (max-width: 768px) {
            .sidebar { width: 280px; transform: translateX(-100%); transition: transform .2s ease; box-shadow: 10px 0 30px rgba(15,23,42,.2); }
            .sidebar.is-open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: inline-grid; place-items: center; }
            .content-wrapper { padding: 18px; }
            .top-navbar { padding: 12px 18px; }
            .user-role { display: none; }
        }
        /* Penyegaran UI global untuk semua modul layanan */
        :root { --brand:#167b68; --brand-dark:#0d5b4e; --ink:#172b2d; --muted:#6f7d7d; --line:#e5eeea; }
        body { background:#f5f8f7; color:var(--ink); }
        .sidebar { width:268px; background:linear-gradient(180deg,#123f3a 0%,#0c2727 100%); }
        .sidebar-header { padding:24px 20px; text-align:left; border-color:rgba(255,255,255,.12); }
        .sidebar-header h3 { font-size:16px; font-weight:800; letter-spacing:.2px; }.sidebar-header p { color:#b3d0c8; margin-top:4px; }
        .sidebar-menu { padding:18px 14px 34px; }.menu-group { margin-bottom:21px; }.menu-group-title { color:#96b9b0; margin-bottom:7px; padding-left:10px; }
        .menu-item { padding:10px 12px; margin:2px 0; color:#d1e2dd; border-radius:9px; }.menu-item:hover { background:rgba(255,255,255,.09); color:#fff; transform:translateX(2px); }.menu-item.active { background:linear-gradient(90deg,#1b9b7b,#19846d); box-shadow:0 7px 15px rgba(0,0,0,.16); }
        .main-content { margin-left:268px; background:#f5f8f7; }.top-navbar { padding:14px 28px; background:rgba(255,255,255,.93); border-bottom:1px solid var(--line); box-shadow:0 3px 13px rgba(20,59,51,.03); backdrop-filter:blur(12px); }.page-title { color:var(--ink); font-weight:800; }.user-name { color:var(--ink); font-weight:700; }.logout-btn { background:#fff1f1; color:#d85050; border-radius:9px; padding:8px 10px; }.logout-btn:hover { background:#fee2e2; }.content-wrapper { padding:28px; }
        .content-wrapper .card { border:1px solid var(--line) !important; border-radius:16px !important; box-shadow:0 8px 22px rgba(27,73,61,.055) !important; overflow:hidden; }.content-wrapper .card-header { padding:18px 22px !important; border-bottom:1px solid var(--line) !important; }.content-wrapper .card-body { padding:22px !important; }
        .content-wrapper .table { margin-bottom:0; }.content-wrapper .table > :not(caption) > * > * { padding:13px 12px; border-color:#edf2ef; vertical-align:middle; }.content-wrapper .table thead th { background:#f5faf7; color:#557069; font-size:11px; text-transform:uppercase; letter-spacing:.35px; white-space:nowrap; }.content-wrapper .table tbody tr:hover > * { background:#f8fcfa; }
        .content-wrapper .form-label { font-weight:700; color:#405450; margin-bottom:7px; }.content-wrapper .form-control,.content-wrapper .form-select { min-height:40px; border-color:#dce8e2; border-radius:9px; font-size:13px; }.content-wrapper .form-control:focus,.content-wrapper .form-select:focus { border-color:#56aa91; box-shadow:0 0 0 3px rgba(22,123,104,.12); }.content-wrapper .btn { border-radius:9px; font-weight:700; font-size:12px; padding:8px 12px; }.content-wrapper .btn-success { background:var(--brand); border-color:var(--brand); }.content-wrapper .btn-success:hover { background:var(--brand-dark); border-color:var(--brand-dark); }.content-wrapper .badge { padding:6px 8px; font-weight:700; border-radius:6px; }.content-wrapper .pagination { --bs-pagination-color:var(--brand); --bs-pagination-active-bg:var(--brand); --bs-pagination-active-border-color:var(--brand); }
        @media (max-width:768px) { .sidebar { width:268px; }.content-wrapper { padding:18px; }.top-navbar { padding:12px 18px; }.content-wrapper .card-body { padding:16px !important; }.content-wrapper .table > :not(caption) > * > * { padding:11px 10px; } }
        .menu-parent { width:100%; border:0; background:transparent; cursor:pointer; text-align:left; }
        .menu-parent .menu-chevron { width:auto; margin-left:auto; font-size:11px; transition:transform .2s ease; }
        .menu-parent[aria-expanded="true"] .menu-chevron { transform:rotate(180deg); }
        .submenu { padding:5px 0 5px 12px; margin:2px 0 6px 10px; border-left:1px solid rgba(179,208,200,.27); }
        .submenu .menu-item { padding:9px 10px; font-size:12px; }.submenu .menu-item i { width:18px; font-size:12px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>🏘️ KAS RT</h3>
            <p>Administrasi warga terpadu</p>
        </div>

        <div class="sidebar-menu">
            @if(auth()->user()->isWarga())
                <!-- ========== MENU KHUSUS WARGA ========== -->
                <div class="menu-group">
                    @php $programActive = request()->routeIs('program-desa.*', 'bank-sampah.*', 'umkm.*', 'surat-menyurat.*', 'posyandu.*', 'ronda.*', 'kegiatan.*', 'aspirasi.*', 'kas.*'); @endphp
                    <button class="menu-item menu-parent {{ $programActive ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#program-desa-warga" aria-expanded="{{ $programActive ? 'true' : 'false' }}">
                        <i class="fas fa-building"></i><span>Program Desa</span><i class="fas fa-chevron-down menu-chevron"></i>
                    </button>
                    <div id="program-desa-warga" class="collapse {{ $programActive ? 'show' : '' }}"><div class="submenu">
                    <a href="{{ route('program-desa.index') }}" class="menu-item {{ request()->routeIs('program-desa.*') ? 'active' : '' }}"><i class="fas fa-border-all"></i><span>Ringkasan Program</span></a>
                    <a href="{{ route('bank-sampah.index') }}" class="menu-item {{ request()->routeIs('bank-sampah.*') ? 'active' : '' }}">
                        <i class="fas fa-recycle"></i><span>Bank Sampah</span>
                    </a>
                            <a href="{{ route('bank-sampah.withdrawals.index') }}" class="menu-item {{ request()->routeIs('bank-sampah.withdrawals.*') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-dollar"></i><span>Riwayat Penarikan</span>
                            </a>
                    <a href="{{ route('umkm.index') }}" class="menu-item {{ request()->routeIs('umkm.*') ? 'active' : '' }}">
                        <i class="fas fa-store"></i><span>UMKM</span>
                    </a>
                    <a href="{{ route('surat-menyurat.index') }}" class="menu-item {{ request()->routeIs('surat-menyurat.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope-open-text"></i><span>Surat Menyurat</span>
                    </a>
                    <a href="{{ route('posyandu.peserta.index') }}" class="menu-item {{ request()->routeIs('posyandu.*') ? 'active' : '' }}">
                        <i class="fas fa-heart"></i><span>Posyandu</span>
                    </a>
                    <a href="{{ route('ronda.index') }}" class="menu-item {{ request()->routeIs('ronda.*') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt"></i><span>Keamanan / Ronda</span>
                    </a>
                    <a href="{{ route('kegiatan.index') }}" class="menu-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i><span>Kegiatan Warga</span>
                    </a>
                    <a href="{{ route('aspirasi.index') }}" class="menu-item {{ request()->routeIs('aspirasi.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i><span>Aspirasi</span>
                    </a>
                    <a href="{{ route('kas.index') }}" class="menu-item {{ request()->routeIs('kas.*') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i><span>Kas</span>
                    </a>
                    </div></div>
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
                    <i class="fas fa-building"></i><span>Dashboard Utama</span>
                </a>
                <a href="{{ route('layanan') }}" class="menu-item {{ request()->routeIs('layanan') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i><span>Layanan</span>
                </a>

                <!-- MASTER DATA GROUP -->
                <div class="menu-group">
                    <div class="menu-group-title">MASTER DATA</div>
                    <a href="{{ route('warga.index') }}" class="menu-item">
                        <i class="fas fa-users"></i><span>Warga</span>
                    </a>
                </div>

                <!-- PROGRAM DESA GROUP -->
                <div class="menu-group">
                    @php $programActive = request()->routeIs('bank-sampah.*', 'umkm.*', 'surat-menyurat.*', 'posyandu.*', 'ronda.*', 'kegiatan.*', 'aspirasi.*', 'kas.*'); @endphp
                    <button class="menu-item menu-parent {{ $programActive ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#program-desa-admin" aria-expanded="{{ $programActive ? 'true' : 'false' }}">
                        <i class="fas fa-building"></i><span>Program Desa</span><i class="fas fa-chevron-down menu-chevron"></i>
                    </button>
                    <div id="program-desa-admin" class="collapse {{ $programActive ? 'show' : '' }}"><div class="submenu">
                    <a href="{{ route('bank-sampah.index') }}" class="menu-item {{ request()->routeIs('bank-sampah.*') ? 'active' : '' }}">
                        <i class="fas fa-recycle"></i><span>Bank Sampah</span>
                    </a>
                    <a href="{{ route('umkm.index') }}" class="menu-item {{ request()->routeIs('umkm.*') ? 'active' : '' }}">
                        <i class="fas fa-store"></i><span>UMKM</span>
                    </a>
                    <a href="{{ route('surat-menyurat.index') }}" class="menu-item {{ request()->routeIs('surat-menyurat.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope-open-text"></i><span>Surat Menyurat</span>
                    </a>
                    <a href="{{ route('posyandu.peserta.index') }}" class="menu-item {{ request()->routeIs('posyandu.*') ? 'active' : '' }}">
                        <i class="fas fa-heart"></i><span>Posyandu</span>
                    </a>
                    <a href="{{ route('ronda.index') }}" class="menu-item {{ request()->routeIs('ronda.*') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt"></i><span>Keamanan / Ronda</span>
                    </a>
                    <a href="{{ route('kegiatan.index') }}" class="menu-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i><span>Kegiatan Warga</span>
                    </a>
                    <a href="{{ route('aspirasi.index') }}" class="menu-item {{ request()->routeIs('aspirasi.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i><span>Aspirasi</span>
                    </a>
                    <a href="{{ route('kas.index') }}" class="menu-item {{ request()->routeIs('kas.*') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i><span>Kas</span>
                    </a>
                    </div></div>
                </div>

                <!-- PENGATURAN GROUP -->
                <div class="menu-group">
                    <div class="menu-group-title">PENGATURAN</div>
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
            <div style="display:flex; align-items:center; gap:12px;">
                <button class="sidebar-toggle" type="button" aria-label="Buka menu" onclick="document.querySelector('.sidebar').classList.toggle('is-open')"><i class="fas fa-bars"></i></button>
                <div>
                    <div class="page-title">@yield('page-title', 'Dashboard')</div>
                    <div class="text-muted" style="font-size:11px; margin-top:2px;">Layanan administrasi warga</div>
                </div>
            </div>
            <div class="user-info">
                <div class="rounded-circle d-grid" style="width:35px;height:35px;place-items:center;background:#e0f3eb;color:#167b68;font-weight:800;">
                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
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
                <div class="flash-message" style="background:#dcfce7; color:#166534;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash-message" style="background:#fee2e2; color:#991b1b;">
{{--  --}}                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <!-- Toast container -->
    <div id="toast-container" style="position:fixed; right:18px; bottom:18px; z-index:2000;"></div>

    <script>
        (function(){
            const container = document.getElementById('toast-container');
            const makeToast = (type, message) => {
                if(!message) return;
                const bg = type === 'success' ? '#16a34a' : '#dc2626';
                const el = document.createElement('div');
                el.style.background = bg;
                el.style.color = '#fff';
                el.style.padding = '12px 16px';
                el.style.borderRadius = '10px';
                el.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
                el.style.marginTop = '8px';
                el.style.minWidth = '220px';
                el.style.fontWeight = '700';
                el.textContent = message;
                container.appendChild(el);
                setTimeout(()=>{ el.style.opacity = '0'; el.style.transition = 'opacity .4s'; setTimeout(()=>el.remove(), 450); }, 4500);
            };
            // flash messages from server
            @if(session('success'))
                makeToast('success', "{{ addslashes(session('success')) }}");
            @endif
            @if(session('error'))
                makeToast('error', "{{ addslashes(session('error')) }}");
            @endif
        })();
    </script>
</body>
</html>
