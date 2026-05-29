<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kas RT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-container { width: 100%; max-width: 800px; }
        .register-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 30px;
        }
        .register-header { text-align: center; margin-bottom: 25px; }
        .register-header h2 { color: white; font-size: 24px; margin-bottom: 5px; }
        .register-header p { color: rgba(255,255,255,0.6); font-size: 13px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255,255,255,0.7); }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: white;
            font-size: 13px;
        }
        .form-control:focus { outline: none; border-color: #667eea; }
        select.form-control option { background: #1a1a2e; }
        .row { display: flex; gap: 15px; flex-wrap: wrap; }
        .col-md-6 { flex: 0 0 calc(50% - 7.5px); }
        .col-md-12 { flex: 0 0 100%; }
        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-register:hover { opacity: 0.9; transform: translateY(-2px); }
        .login-link { text-align: center; margin-top: 20px; font-size: 12px; color: rgba(255,255,255,0.6); }
        .login-link a { color: #667eea; text-decoration: none; }
        @media (max-width: 600px) { .col-md-6 { flex: 0 0 100%; } }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h2><i class="fas fa-user-plus"></i> Daftar Akun Baru</h2>
                <p>Silakan isi data diri Anda dengan lengkap</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> NIK</label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="16 digit NIK">
                            @error('nik')<div style="color:#fca5a5; font-size:11px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Nama sesuai KTP">
                            @error('nama_lengkap')<div style="color:#fca5a5; font-size:11px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user-circle"></i> Nama Panggilan</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Nama panggilan">
                            @error('name')<div style="color:#fca5a5; font-size:11px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="email@example.com">
                            @error('email')<div style="color:#fca5a5; font-size:11px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="Kota lahir">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-day"></i> Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-pray"></i> Agama</label>
                            <select name="agama" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-ring"></i> Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-briefcase"></i> Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> RT / RW</label>
                            <input type="text" name="rt_rw" class="form-control" value="{{ old('rt_rw') }}" placeholder="01/03">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="08123456789">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div style="color:#fca5a5; font-size:11px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><i class="fas fa-home"></i> Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn-register"><i class="fas fa-user-plus"></i> Daftar</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
            </div>
        </div>
    </div>
</body>
</html>