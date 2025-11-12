{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Registrasi Warga')

@push('styles')
<style>
    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        position: relative;
        overflow: hidden;
        padding: 40px 0;
    }

    /* Animated background shapes */
    .register-wrapper::before,
    .register-wrapper::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }

    .register-wrapper::before {
        width: 500px;
        height: 500px;
        top: -150px;
        right: -150px;
        animation: float 7s ease-in-out infinite;
    }

    .register-wrapper::after {
        width: 350px;
        height: 350px;
        bottom: -100px;
        left: -100px;
        animation: float 9s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(5deg); }
    }

    .register-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0,0,0,0.3);
        overflow: hidden;
        position: relative;
        z-index: 1;
        animation: slideUp 0.7s ease-out;
        max-width: 700px;
        margin: 0 auto;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .register-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        padding: 35px 30px;
        text-align: center;
        position: relative;
    }

    .register-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        background: white;
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
    }

    .register-icon {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.25);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.4);
    }

    .register-icon i {
        font-size: 2rem;
        color: white;
    }

    .register-title {
        color: white;
        font-size: 1.75rem;
        font-weight: bold;
        margin: 0;
    }

    .register-subtitle {
        color: rgba(255,255,255,0.95);
        margin-top: 5px;
        font-size: 0.95rem;
    }

    .register-body {
        padding: 40px 35px 35px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-label .text-danger {
        color: #e74c3c !important;
    }

    .form-control, .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 11px 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #11998e;
        box-shadow: 0 0 0 0.2rem rgba(17, 153, 142, 0.25);
    }

    .input-group-text {
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: #666;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }

    .input-group:focus-within .input-group-text {
        border-color: #11998e;
        background: #e8f8f5;
        color: #11998e;
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 5px;
        transition: color 0.3s ease;
        z-index: 10;
    }

    .password-toggle:hover {
        color: #11998e;
    }

    .form-text {
        font-size: 0.8rem;
        color: #666;
        margin-top: 5px;
    }

    .alert-info-custom {
        background: linear-gradient(135deg, #e8f8f5 0%, #d4f1e8 100%);
        border: 2px solid #11998e;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .alert-info-custom i {
        color: #11998e;
        font-size: 1.2rem;
    }

    .alert-info-custom strong {
        color: #0d7f73;
    }

    .btn-register {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }

    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(17, 153, 142, 0.6);
        background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 25px;
        border-top: 2px solid #e0e0e0;
    }

    .login-link a {
        color: #11998e;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .login-link a:hover {
        color: #0d7f73;
        text-decoration: underline;
    }

    /* Step indicator */
    .step-indicator {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .step-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #d0d0d0;
        transition: all 0.3s ease;
    }

    .step-dot.active {
        background: #11998e;
        width: 30px;
        border-radius: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .register-body {
            padding: 30px 20px 25px;
        }

        .register-header {
            padding: 25px 20px;
        }

        .register-title {
            font-size: 1.4rem;
        }
    }
</style>
@endpush

@section('content')
<div class="register-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="register-card">
                    <!-- Header -->
                    <div class="register-header">
                        <div class="register-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h1 class="register-title">Registrasi Akun Baru</h1>
                        <p class="register-subtitle">Daftar untuk mengakses layanan surat online</p>
                    </div>

                    <!-- Body -->
                    <div class="register-body">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step-dot active"></div>
                            <div class="step-dot"></div>
                            <div class="step-dot"></div>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- NIK -->
                            <div class="mb-4">
                                <label for="nik" class="form-label">
                                    <i class="fas fa-id-card me-2"></i>NIK <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input id="nik" type="text"
                                           class="form-control @error('nik') is-invalid @enderror"
                                           name="nik" value="{{ old('nik') }}"
                                           required maxlength="16" pattern="[0-9]{16}"
                                           placeholder="Masukkan 16 digit NIK">
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <small class="form-text">Nomor Induk Kependudukan 16 digit</small>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label for="nama_lengkap" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="nama_lengkap" type="text"
                                           class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                           required placeholder="Masukkan nama lengkap sesuai KTP">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tempat & Tanggal Lahir -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="tempat_lahir" class="form-label">
                                        <i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <input id="tempat_lahir" type="text"
                                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                                               name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                               required placeholder="Kota/Kabupaten">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="tanggal_lahir" class="form-label">
                                        <i class="fas fa-calendar me-2"></i>Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <input id="tanggal_lahir" type="date"
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                               name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-4">
                                <label for="jenis_kelamin" class="form-label">
                                    <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-venus-mars"></i>
                                    </span>
                                    <select id="jenis_kelamin"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group password-wrapper">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required placeholder="Min. 8 karakter">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                            <i class="fas fa-eye" id="toggleIcon1"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="password-confirm" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group password-wrapper">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input id="password-confirm" type="password"
                                               class="form-control" name="password_confirmation"
                                               required placeholder="Ulangi password">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password-confirm', 'toggleIcon2')">
                                            <i class="fas fa-eye" id="toggleIcon2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Alert -->
                            <div class="alert-info-custom">
                                <i class="fas fa-info-circle"></i>
                                <strong> Informasi:</strong> Data lainnya seperti alamat, agama, pekerjaan, dll.
                                dapat dilengkapi nanti di halaman Profile setelah login.
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-register">
                                    <i class="fas fa-user-check me-2"></i>Daftar Sekarang
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="login-link">
                                <p class="mb-0 text-muted">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}">
                                        Login di sini <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Success Registration Handler
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil!',
            html: '<p class="mb-2">{{ session('success') }}</p><p class="text-muted">Anda akan dialihkan ke halaman login dalam <strong id="countdown">3</strong> detik...</p>',
            showConfirmButton: true,
            confirmButtonText: 'Login Sekarang',
            confirmButtonColor: '#11998e',
            allowOutsideClick: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                const countdownElement = document.getElementById('countdown');
                let timeLeft = 3;

                const interval = setInterval(() => {
                    timeLeft--;
                    if (countdownElement && timeLeft > 0) {
                        countdownElement.textContent = timeLeft;
                    }
                    if (timeLeft <= 0) {
                        clearInterval(interval);
                    }
                }, 1000);
            }
        }).then((result) => {
            window.location.href = '{{ route('login') }}';
        });
    @endif
</script>
@endpush
@endsection
