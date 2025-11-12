{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Sistem Surat Desa</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Modern Navbar & Sidebar Styles */
        .main-header.navbar {
            border-bottom: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .main-header .navbar-nav .nav-link {
            color: #4a5568;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .main-header .navbar-nav .nav-link:hover {
            color: #667eea;
        }

        .main-sidebar {
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
        }

        .sidebar-dark-primary .brand-link {
            background: #343a40;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-dark-primary .brand-link:hover {
            background: #3f474e;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background: #007bff;
            color: white;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active:hover {
            background: #0069d9;
        }

        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }

        .content-wrapper {
            background: #f8f9fa;
        }

        .content-header h1 {
            color: #2d3748;
            font-weight: 700;
        }

        .breadcrumb {
            background: transparent;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: #cbd5e0;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #718096;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    {{ Auth::user()->nama_lengkap }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">
                        {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Warga' }}
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('warga.dashboard') }}"
                       class="dropdown-item">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    @if(Auth::user()->role == 'warga')
                    <a href="{{ route('warga.profile.show') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile Saya
                    </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('warga.dashboard') }}" class="brand-link">
            <i class="fas fa-envelope brand-icon"></i>
            <span class="brand-text font-weight-light">Sistem Surat Desa</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    @if(Auth::user()->role == 'admin')
                        @include('layouts.sidebar-admin')
                    @else
                        @include('layouts.sidebar-warga')
                    @endif
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2025 <a href="#">Sistem Surat Desa Gedung Harapan</a>.</strong>
        All rights reserved.
    </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Global SweetAlert Handler for Session Messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            background: '#f0fdf4',
            iconColor: '#22c55e'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            background: '#fef2f2',
            iconColor: '#ef4444'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: '<ul style="text-align: left; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#667eea'
        });
    @endif
</script>
@stack('scripts')
</body>
</html>
