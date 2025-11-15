<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sistem Surat Desa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .admin-login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.5s ease-out;
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

        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            opacity: 0.1;
        }

        .admin-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .admin-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .admin-header p {
            font-size: 0.95rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .admin-body {
            padding: 40px 35px;
        }

        .alert-info {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 2px solid #0ea5e9;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            color: #0c4a6e;
            font-size: 0.9rem;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .alert-info i {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
        }

        .remember-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
        }

        .remember-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-wrapper label {
            margin: 0;
            cursor: pointer;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #9ca3af;
            font-size: 0.85rem;
            position: relative;
            z-index: 1;
        }

        .back-to-warga {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-warga a {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .back-to-warga a:hover {
            background: #f3f4f6;
            color: #667eea;
        }

        .admin-footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 0.85rem;
        }

        @media (max-width: 576px) {
            .admin-header {
                padding: 30px 20px;
            }

            .admin-header h2 {
                font-size: 1.5rem;
            }

            .admin-icon {
                font-size: 3rem;
            }

            .admin-body {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-header">
            <div class="admin-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <h2>Admin Panel</h2>
            <p>Sistem Informasi Surat Desa</p>
        </div>

        <div class="admin-body">
            <div class="alert-info">
                <i class="fas fa-shield-halved"></i>
                <div>
                    <strong>Area Khusus Administrator</strong><br>
                    <small>Hanya administrator yang memiliki akses ke halaman ini</small>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}" id="adminLoginForm">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               id="username"
                               name="username"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username admin"
                               autofocus
                               required>
                    </div>
                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Masukkan password"
                               required>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-wrapper">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login ke Admin Panel</span>
                </button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="back-to-warga">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login Warga
                </a>
            </div>
        </div>

        <div class="admin-footer">
            <i class="fas fa-lock"></i> Halaman ini dilindungi dan hanya untuk administrator
        </div>
    </div>

    @if(session('admin_login_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: 'Selamat datang, {{ session('admin_login_success.name') }}',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = "{{ route('admin.dashboard') }}";
            });
        });
    </script>
    @endif

    @if(session('admin_logout_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Logout Berhasil',
                text: 'Anda telah keluar dari admin panel',
                timer: 2000,
                showConfirmButton: false,
            });
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#667eea',
            });
        });
    </script>
    @endif
</body>
</html>
