@extends('layouts.app')

@section('title', 'Profil Saya - Desa Rafi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">👤 Profil Saya</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px; font-size: 50px;">
                            👨‍💼
                        </div>
                    </div>
                    <h3>{{ auth()->user()->name }}</h3>
                    <p class="text-muted">
                        <span class="badge bg-primary">{{ auth()->user()->role->display_name }}</span>
                    </p>
                    <p>
                        <i class="bi bi-envelope"></i> {{ auth()->user()->email }}
                    </p>
                </div>
            </div>

            <!-- Update Profile Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">✏️ Edit Profil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            💾 Update Profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">🔒 Ganti Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            🔑 Ganti Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Delete Account Section (Only for Admin) -->
            @if(auth()->user()->isAdmin())
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">⚠️ Hapus Akun</h5>
                </div>
                <div class="card-body">
                    <p class="text-danger">Peringatan: Menghapus akun akan menghapus semua data Anda secara permanen.</p>
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        🗑️ Hapus Akun
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">⚠️ Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun <strong>{{ auth()->user()->name }}</strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Masukkan Password untuk Konfirmasi</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-danger">Ya, Hapus Akun Saya</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .rounded-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .card {
        border: none;
        border-radius: 15px;
    }
    .card-header {
        border-radius: 15px 15px 0 0;
    }
</style>
@endsection