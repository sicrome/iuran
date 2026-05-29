<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Kas RT | Sistem Informasi Kas RT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Gradient Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: float 20s infinite ease-in-out;
            z-index: 0;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: rgba(102, 126, 234, 0.3);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: rgba(118, 75, 162, 0.3);
            bottom: -150px;
            right: -150px;
            animation-delay: 5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: rgba(236, 72, 153, 0.2);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 1150px;
            position: relative;
            z-index: 10;
        }

        /* Main Wrapper */
        .login-wrapper {
            display: flex;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 48px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* LEFT SECTION - WELCOME */
        .welcome-section {
            flex: 1.2;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-area {
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .welcome-text {
            position: relative;
            z-index: 1;
        }

        .welcome-text h1 {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .welcome-text p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* Features List */
        .features-list {
            list-style: none;
            margin-top: 40px;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .features-list li i {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #a78bfa;
        }

        /* RIGHT SECTION - FORM */
        .form-section {
            flex: 0.8;
            padding: 50px 45px;
            background: rgba(0, 0, 0, 0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        .input-icon {
            padding: 13px 16px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-group input {
            flex: 1;
            padding: 13px 16px;
            background: transparent;
            border: none;
            outline: none;
            color: white;
            font-size: 14px;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        /* Options */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .checkbox input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .forgot-link {
            font-size: 12px;
            color: #a78bfa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #fff;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        /* Divider */
        .divider {
            margin: 25px 0;
            text-align: center;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        .divider span {
            background: rgba(0,0,0,0.3);
            padding: 0 15px;
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            position: relative;
            z-index: 1;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 25px;
        }

        .register-link a {
            color: #a78bfa;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #fff;
        }

        /* Demo Accounts */
        .demo-accounts {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .demo-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            text-align: center;
            margin-bottom: 12px;
        }

        .demo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .demo-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(5px);
        }

        .demo-role {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .role-admin { color: #a78bfa; }
        .role-bendahara { color: #6ee7b7; }
        .role-warga { color: #67e8f9; }

        .demo-email {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Alert */
        .alert {
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        .alert-info {
            background: rgba(6, 182, 212, 0.15);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: #67e8f9;
        }

        /* Toast */
        .toast-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            z-index: 9999;
            animation: slideIn 0.3s ease, fadeOut 0.3s ease 1.7s forwards;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.2);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            to { opacity: 0; visibility: hidden; }
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.3);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .login-wrapper {
                flex-direction: column;
            }
            .welcome-section {
                padding: 35px 30px;
                text-align: center;
            }
            .features-list {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
                justify-content: center;
            }
            .features-list li {
                width: calc(50% - 15px);
            }
        }

        @media (max-width: 500px) {
            .form-section {
                padding: 35px 25px;
            }
            .welcome-text h1 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-container">
        <div class="login-wrapper">
            <!-- LEFT SECTION - WELCOME -->
            <div class="welcome-section">
                <div class="logo-area">
                    <div class="logo-icon">🏘️</div>
                </div>
                <div class="welcome-text">
                    <h1>Kelola Keuangan<br>RT dengan Mudah</h1>
                    <p>Sistem Informasi Kas RT adalah solusi terbaik untuk mengelola keuangan lingkungan Anda secara transparan, efisien, dan profesional.</p>
                </div>
                <ul class="features-list">
                    <li><i class="fas fa-chart-line"></i> Laporan Keuangan Real-time</li>
                    <li><i class="fas fa-upload"></i> Bayar Iuran Online</li>
                    <li><i class="fas fa-database"></i> Backup Data Otomatis</li>
                    <li><i class="fas fa-shield-alt"></i> Sistem Keamanan Terjamin</li>
                </ul>
            </div>

            <!-- RIGHT SECTION - FORM -->
            <div class="form-section">
                <div class="form-header">
                    <h2>Selamat Datang Kembali!</h2>
                    <p>Silakan masuk ke akun Anda</p>
                </div>

                @if(session('info'))
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> {{ session('info') }}
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Login Gagal! Periksa email dan password Anda.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Alamat Email</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   placeholder="admin@kasrt.com" required autofocus id="email-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password-input" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="options">
                        <label class="checkbox">
                            <input type="checkbox" name="remember"> Ingat Saya
                        </label>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-arrow-right-to-bracket"></i> MASUK
                    </button>
                </form>

                <div class="divider"><span>atau</span></div>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a>
                </div>

                <!-- Demo Accounts -->
                <div class="demo-accounts">
                    <div class="demo-title">
                        <i class="fas fa-code-branch"></i> Akun Demo
                    </div>
                    <div class="demo-item" onclick="fillLoginForm('admin@kasrt.com', 'password')">
                        <div class="demo-role">
                            <i class="fas fa-crown"></i>
                            <span class="role-admin">Administrator</span>
                        </div>
                        <div class="demo-email">admin@kasrt.com</div>
                    </div>
                    <div class="demo-item" onclick="fillLoginForm('bendahara@kasrt.com', 'password')">
                        <div class="demo-role">
                            <i class="fas fa-chart-line"></i>
                            <span class="role-bendahara">Bendahara</span>
                        </div>
                        <div class="demo-email">bendahara@kasrt.com</div>
                    </div>
                    <div class="demo-item" onclick="fillLoginForm('warga1@kasrt.com', 'password')">
                        <div class="demo-role">
                            <i class="fas fa-user"></i>
                            <span class="role-warga">Warga</span>
                        </div>
                        <div class="demo-email">warga1@kasrt.com</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <i class="fas fa-shield-alt"></i> Sistem Informasi Kas RT v3.0 | © 2025
        </div>
    </div>

    <script>
        function fillLoginForm(email, password) {
            document.getElementById('email-input').value = email;
            document.getElementById('password-input').value = password;
            showToast('✅ Akun "' + email + '" siap login!');
            
            // Highlight effect
            const emailInput = document.getElementById('email-input');
            const passwordInput = document.getElementById('password-input');
            emailInput.style.boxShadow = '0 0 0 2px rgba(16,185,129,0.5)';
            passwordInput.style.boxShadow = '0 0 0 2px rgba(16,185,129,0.5)';
            setTimeout(() => {
                emailInput.style.boxShadow = '';
                passwordInput.style.boxShadow = '';
            }, 1000);
        }
        
        function showToast(message) {
            const existingToast = document.querySelector('.toast-message');
            if (existingToast) existingToast.remove();
            
            const toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.innerHTML = '<i class="fas fa-check-circle"></i> ' + message;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.remove(), 2000);
        }
    </script>
</body>
</html>