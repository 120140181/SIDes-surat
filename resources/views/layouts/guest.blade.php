{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <title>@yield('title', 'Sistem Surat Desa Gedung Harapan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Back to Home Button for Auth Pages */
        .back-to-home {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1040;
            background: rgba(255,255,255,0.95);
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-to-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: #667eea;
        }

        .back-to-home i {
            transition: transform 0.3s ease;
        }

        .back-to-home:hover i {
            transform: translateX(-3px);
        }

        /* Mobile Responsive for Back Button */
        @media (max-width: 768px) {
            .back-to-home {
                top: 15px;
                left: 15px;
                padding: 10px 14px;
                font-size: 0.85rem;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            }

            .back-to-home i {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            /* Ubah jadi tombol icon saja di mobile */
            .back-to-home {
                top: 12px;
                left: 12px;
                padding: 10px;
                width: 42px;
                height: 42px;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            }

            .back-to-home span {
                display: none; /* Hide text, show icon only */
            }

            .back-to-home i {
                font-size: 1rem;
                margin: 0;
            }
        }

        /* Alternative: Transparent style on mobile */
        @media (max-width: 576px) {
            .back-to-home {
                background: rgba(255,255,255,0.25);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.3);
            }

            .back-to-home:active {
                background: rgba(255,255,255,0.4);
            }
        }

        /* Navbar Gradient & Sticky */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            transition: all 0.4s ease;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: none;
        }

        .navbar.scrolled {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
            transition: color 0.4s ease;
        }

        .navbar.scrolled .navbar-brand {
            color: #667eea !important;
        }

        .navbar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: color 0.4s ease;
        }

        .navbar .nav-link:hover {
            color: white !important;
        }

        .navbar.scrolled .nav-link {
            color: #333 !important;
        }

        .navbar.scrolled .nav-link:hover {
            color: #667eea !important;
        }

        .navbar .navbar-brand i {
            color: white;
            transition: color 0.4s ease;
        }

        .navbar.scrolled .navbar-brand i {
            color: #667eea;
        }

        /* Navbar toggler untuk mobile */
        .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }

        .navbar.scrolled .navbar-toggler {
            border-color: rgba(0,0,0,0.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar.scrolled .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 0.55)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Hero section dengan proporsi yang lebih baik */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding-top: 140px;
            padding-bottom: 100px;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }
        .feature-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        .card-hover {
            transition: transform 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
        }
        .status-indicator {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
        .min-vh-80 {
            min-height: 80vh;
        }

        /* Enhanced Footer Styles */
        .enhanced-footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #667eea 100%);
            position: relative;
            overflow: hidden;
        }

        .enhanced-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #11998e, #38ef7d);
            background-size: 200% 100%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { background-position: 0% 0%; }
            50% { background-position: 100% 0%; }
        }

        .footer-wave {
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 50px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 100'%3E%3Cpath fill='%231e3c72' d='M0,50 Q300,0 600,50 T1200,50 L1200,100 L0,100 Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
            background-size: 1200px 100px;
            animation: wave 10s linear infinite;
        }

        @keyframes wave {
            0% { background-position: 0 0; }
            100% { background-position: 1200px 0; }
        }

        .footer-content {
            position: relative;
            z-index: 1;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(45deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            padding: 5px 0;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .footer-social a:hover {
            background: white;
            color: #667eea;
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 10px 25px rgba(255,255,255,0.3);
        }

        .footer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            margin: 2rem 0;
        }

        .footer-info {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .footer-info i {
            color: #38ef7d;
            font-size: 1.2rem;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column">
    <!-- Back to Home Button (hanya tampil di login & register) -->
    @if(request()->routeIs('login') || request()->routeIs('register'))
        <a href="{{ url('/') }}" class="back-to-home">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
    @endif

    <!-- Navbar (hide di login & register) -->
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-envelope"></i>
                Sistem Surat Desa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @endif

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer (hide di login & register) -->
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <footer class="enhanced-footer text-white py-5 mt-auto">
        <div class="footer-wave"></div>
        <div class="container footer-content">
            <div class="row g-4">
                <!-- Brand & Description -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-brand">
                        <i class="fas fa-envelope me-2"></i>
                        SIDes Surat
                    </div>
                    <p class="text-white-50 mb-4">
                        Sistem Informasi Desa untuk pengurusan surat menyurat secara online.
                        Cepat, mudah, dan transparan untuk warga Desa Gedung Harapan.
                    </p>
                    <div class="footer-social d-flex gap-3">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Menu</h5>
                    <div class="footer-links d-flex flex-column gap-2">
                        <a href="/"><i class="fas fa-home me-2"></i>Beranda</a>
                        <a href="#layanan"><i class="fas fa-list me-2"></i>Layanan</a>
                        <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                        <a href="{{ route('register') }}"><i class="fas fa-user-plus me-2"></i>Register</a>
                    </div>
                </div>

                <!-- Jenis Surat -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Jenis Surat</h5>
                    <div class="footer-links d-flex flex-column gap-2">
                        <a href="#"><i class="fas fa-file-alt me-2"></i>Surat Keterangan</a>
                        <a href="#"><i class="fas fa-envelope me-2"></i>Surat Pengantar</a>
                        <a href="#"><i class="fas fa-certificate me-2"></i>Surat Izin</a>
                        <a href="#"><i class="fas fa-ellipsis-h me-2"></i>Lainnya</a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <div class="footer-info">
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <small>Desa Gedung Harapan<br>Kec. Gedung Harapan</small>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            <small>(021) 1234-5678</small>
                        </div>
                        <div>
                            <i class="fas fa-envelope me-2"></i>
                            <small>info@gedungharapan.desa.id</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-divider"></div>

            <!-- Copyright -->
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 text-white-50">
                        <i class="fas fa-heart text-danger"></i>
                        Made with love for Desa Gedung Harapan
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-white-50">
                        &copy; 2025 <strong>SIDes Surat</strong>. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Navbar Scroll Effect -->
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar && window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else if (navbar) {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    <!-- SweetAlert for Session Messages -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
