{{-- resources/views/welcome.blade.php --}}
@extends('layouts.guest')

@section('title', 'Sistem Surat Desa Harapan Jaya')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h1 class="display-4 mb-4">Sistem Surat Desa Harapan Jaya</h1>
                <p class="lead mb-5">Layanan pengajuan surat menyurat secara online untuk warga Desa Harapan Jaya</p>

                <div class="row mt-5">
                    <div class="col-md-6 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-dark">Warga Desa</h5>
                                <p class="card-text text-muted">Ajukan surat keterangan secara online dan pantau status pengajuannya</p>
                                <a href="{{ route('login') }}" class="btn btn-primary me-2">Login Warga</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar Warga</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-dark">Admin/Pegawai</h5>
                                <p class="card-text text-muted">Kelola pengajuan surat dari warga dan validasi proses surat</p>
                                <a href="{{ route('login') }}" class="btn btn-success">Login Admin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Mengapa Menggunakan Sistem Ini?</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="fas fa-paper-plane fa-3x text-primary mb-3"></i>
                <h4>Ajukan Online</h4>
                <p class="text-muted">Ajukan surat secara online tanpa perlu antri di kantor desa</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-sync-alt fa-3x text-success mb-3"></i>
                <h4>Pantau Status</h4>
                <p class="text-muted">Pantau status pengajuan surat kapan saja dan di mana saja</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-bell fa-3x text-warning mb-3"></i>
                <h4>Notifikasi Real-time</h4>
                <p class="text-muted">Dapatkan notifikasi ketika surat sudah siap untuk diambil</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Cara Kerja Sistem</h2>
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-user-plus fa-2x"></i>
                </div>
                <h5>1. Daftar/Login</h5>
                <p class="text-muted">Daftar sebagai warga atau login ke akun Anda</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-edit fa-2x"></i>
                </div>
                <h5>2. Ajukan Surat</h5>
                <p class="text-muted">Isi form pengajuan surat dengan data yang diperlukan</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-cog fa-2x"></i>
                </div>
                <h5>3. Proses Verifikasi</h5>
                <p class="text-muted">Admin akan memverifikasi dan memproses surat Anda</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <h5>4. Selesai & Ambil</h5>
                <p class="text-muted">Ambil surat fisik di kantor desa ketika status selesai</p>
            </div>
        </div>
    </div>
</section>
@endsection
