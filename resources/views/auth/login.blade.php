{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
<style>
    /* Loading Screen */
    .loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .loading-screen.active {
        opacity: 1;
        visibility: visible;
    }

    .loading-screen.fade-out {
        opacity: 0;
    }

    .loading-content {
        text-align: center;
        color: white;
    }

    .loading-icon-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Animated circles background */
    .loading-icon-wrapper::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        animation: ripple 1.5s ease-out infinite;
    }

    .loading-icon-wrapper::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        animation: ripple 1.5s ease-out infinite;
        animation-delay: 0.75s;
    }

    @keyframes ripple {
        0% {
            transform: scale(0.8);
            opacity: 1;
        }
        100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }

    .loading-icon {
        font-size: 6rem;
        position: relative;
        z-index: 2;
        animation: checkPopIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards,
                   checkGlow 1.5s ease-in-out infinite 0.6s;
        color: white;
        text-shadow: 0 0 20px rgba(255,255,255,0.8),
                     0 0 40px rgba(255,255,255,0.6),
                     0 0 60px rgba(255,255,255,0.4);
        transform: scale(0);
    }

    @keyframes checkPopIn {
        0% {
            transform: scale(0) rotate(-180deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.2) rotate(10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    @keyframes checkGlow {
        0%, 100% {
            text-shadow: 0 0 20px rgba(255,255,255,0.8),
                         0 0 40px rgba(255,255,255,0.6),
                         0 0 60px rgba(255,255,255,0.4);
        }
        50% {
            text-shadow: 0 0 30px rgba(255,255,255,1),
                         0 0 60px rgba(255,255,255,0.8),
                         0 0 90px rgba(255,255,255,0.6);
        }
    }

    .loading-text {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
        animation: pulse 1.5s ease-in-out infinite;
    }

    .loading-subtext {
        font-size: 1rem;
        opacity: 0.9;
    }

    .loading-dots::after {
        content: '';
        animation: dots 1.5s steps(4, end) infinite;
    }

    @keyframes dots {
        0%, 20% { content: ''; }
        40% { content: '.'; }
        60% { content: '..'; }
        80%, 100% { content: '...'; }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    /* Animated background circles */
    .login-wrapper::before,
    .login-wrapper::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
    }

    .login-wrapper::before {
        width: 400px;
        height: 400px;
        top: -100px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }

    .login-wrapper::after {
        width: 300px;
        height: 300px;
        bottom: -80px;
        left: -80px;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .login-card {
        margin-top: 40px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        overflow: hidden;
        position: relative;
        z-index: 1;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }

    .login-header::before {
        content: '';
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 40px solid transparent;
        border-right: 40px solid transparent;
        border-top: 30px solid #764ba2;
    }

    .login-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.3);
    }

    .login-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .login-title {
        color: white;
        font-size: 1.8rem;
        font-weight: bold;
        margin: 0;
    }

    .login-subtitle {
        color: rgba(255,255,255,0.9);
        margin-top: 5px;
    }

    .login-body {
        padding: 60px 40px 40px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
        font-size: 1.2rem;
        padding: 5px;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: #667eea;
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .register-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #e0e0e0;
    }

    .register-link a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .register-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Input icons */
    .input-group-text {
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-right: none;
        border-radius: 10px 0 0 10px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }

    .input-group:focus-within .input-group-text {
        border-color: #667eea;
        background: #f0f4ff;
        color: #667eea;
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="login-card">
                    <!-- Header -->
                    <div class="login-header">
                        <div class="login-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h1 class="login-title">Selamat Datang</h1>
                        <p class="login-subtitle">Silakan login untuk melanjutkan</p>
                    </div>

                    <!-- Body -->
                    <div class="login-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- NIK Input -->
                            <div class="mb-4">
                                <label for="nik" class="form-label">
                                    <i class="fas fa-id-card me-2"></i>NIK
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input id="nik" type="text"
                                           class="form-control @error('nik') is-invalid @enderror"
                                           name="nik" value="{{ old('nik') }}"
                                           required autofocus maxlength="16" pattern="[0-9]{16}"
                                           placeholder="Masukkan 16 digit NIK">
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="input-group password-wrapper">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required placeholder="Masukkan password">
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="register-link">
                                <p class="mb-0 text-muted">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}">
                                        Daftar di sini <i class="fas fa-arrow-right ms-1"></i>
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

<!-- Loading Screen -->
<div class="loading-screen" id="loadingScreen">
    <div class="loading-content">
        <div class="loading-icon-wrapper">
            <div class="loading-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <h2 class="loading-text">Login Berhasil!</h2>
        <p class="loading-subtext">
            Mengarahkan ke dashboard<span class="loading-dots"></span>
        </p>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

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

    // Success Login Handler with Loading Screen Only
    @if(session('login_success'))
        @php
            $loginData = session('login_success');
        @endphp

        document.addEventListener('DOMContentLoaded', function() {
            const loadingScreen = document.getElementById('loadingScreen');

            // Langsung tampilkan loading screen
            setTimeout(() => {
                loadingScreen.classList.add('active');

                // Fade out setelah 2 detik
                setTimeout(() => {
                    loadingScreen.classList.add('fade-out');

                    // Redirect setelah fade out selesai
                    setTimeout(() => {
                        window.location.href = '{{ $loginData['redirect'] }}';
                    }, 500);
                }, 2000);
            }, 100);
        });
    @endif

    // Success message from registration
    @if(session('success') && !session('login_success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            background: '#f0f9ff',
            iconColor: '#667eea'
        });
    @endif
</script>
@endpush
@endsection
