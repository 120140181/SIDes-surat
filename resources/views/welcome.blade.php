{{-- resources/views/welcome.blade.php --}}
@extends('layouts.guest')

@section('title', 'Sistem Surat Desa Gedung Harapan')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Sistem Informasi Surat Desa Gedung Harapan
                    </h1>
                    <p class="lead mb-4">
                        Layanan pengurusan surat menyurat secara online yang cepat, mudah, dan transparan untuk warga Desa Gedung Harapan.
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-person-plus"></i> Daftar Akun
                            </a>
                        @endauth
                        <a href="#layanan" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-info-circle"></i> Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-envelope-paper display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

<!-- Features Section -->
    <section id="layanan" class="py-5" style="margin-bottom: 100px">
        <div class="container">
            <div class="text-center my-lg-5">
                <h2 class="fw-bold">Layanan Surat Kami</h2>
                <p class="text-muted">Berbagai jenis layanan surat yang dapat diajukan secara online</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 card-hover border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-file-text feature-icon"></i>
                            <h5 class="card-title">Surat Keterangan</h5>
                            <p class="card-text text-muted">
                                Surat keterangan domisili, tidak mampu, usaha, dan lainnya untuk keperluan administratif.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 card-hover border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-person-vcard feature-icon"></i>
                            <h5 class="card-title">Surat Pengantar</h5>
                            <p class="card-text text-muted">
                                Surat pengantar untuk berbagai keperluan seperti pembuatan KTP, KK, dan dokumen kependudukan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 card-hover border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-building feature-icon"></i>
                            <h5 class="card-title">Surat Izin</h5>
                            <p class="card-text text-muted">
                                Surat izin keramaian, izin mendirikan bangunan, dan perizinan lainnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Status Layanan Real-time -->
    <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-bottom: 100px;">
        <div class="container">
            <h2 class="text-center text-white mb-5">Status Layanan Saat Ini</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <div class="row text-center">
                                @php
                                    $now = now();
                                    $isWeekday = $now->isWeekday() && !$now->isFriday();
                                    $isFriday = $now->isFriday();
                                    $isWeekend = $now->isWeekend();

                                    $currentHour = $now->hour;
                                    $isMorning = $currentHour >= 8 && $currentHour < 12;
                                    $isAfternoon = $currentHour >= 13 && $currentHour < 16;
                                    $isOpen = ($isWeekday || $isFriday) && ($isMorning || $isAfternoon);

                                    $nextOpen = null;
                                    if (!$isOpen) {
                                        if ($isWeekend) {
                                            $nextOpen = $now->copy()->next('Monday')->setTime(8, 0);
                                        } elseif ($currentHour < 8) {
                                            $nextOpen = $now->copy()->setTime(8, 0);
                                        } elseif ($currentHour >= 12 && $currentHour < 13) {
                                            $nextOpen = $now->copy()->setTime(13, 0);
                                        } else {
                                            $nextOpen = $now->copy()->addDay()->setTime(8, 0);
                                        }
                                    }
                                @endphp

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="me-3">
                                            <div class="status-indicator {{ $isOpen ? 'bg-success' : 'bg-danger' }}">
                                                <i class="fas fa-{{ $isOpen ? 'check' : 'times' }}"></i>
                                            </div>
                                        </div>
                                        <div class="text-start">
                                            <h4 class="mb-1 {{ $isOpen ? 'text-success' : 'text-danger' }}">
                                                {{ $isOpen ? 'BUKA' : 'TUTUP' }}
                                            </h4>
                                            <p class="text-muted mb-0">
                                                @if($isOpen)
                                                    Layanan sedang berjalan
                                                @else
                                                    Layanan sedang tutup
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="text-center">
                                        <h5 class="text-primary">
                                            <i class="fas fa-clock me-2"></i>
                                            {{ $now->format('H:i') }}
                                        </h5>
                                        <p class="text-muted mb-0">
                                            {{ $now->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if(!$isOpen && $nextOpen)
                            <div class="alert alert-warning mt-3 text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Kantor desa akan buka kembali pada
                                <strong>{{ $nextOpen->translatedFormat('l, d F Y') }}</strong>
                                pukul <strong>{{ $nextOpen->format('H:i') }}</strong>
                            </div>
                            @endif

                            @if($isOpen)
                            <div class="alert alert-success mt-3 text-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Kantor desa sedang buka!</strong> Anda bisa mengajukan surat online atau datang langsung ke kantor desa.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 my-5" style="margin-bottom: 200px">
        <div class="container">
            <h2 class="text-center mb-5">Cara Kerja Sistem</h2>
            <div class="row">
                <div class="col-md-3 text-center mb-4 card-hover">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h5>1. Daftar/Login</h5>
                    <p class="text-muted">Daftar sebagai warga atau login ke akun Anda</p>
                </div>
                <div class="col-md-3 text-center mb-4 card-hover">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-edit fa-2x"></i>
                    </div>
                    <h5>2. Ajukan Surat</h5>
                    <p class="text-muted">Isi form pengajuan surat dengan data yang diperlukan</p>
                </div>
                <div class="col-md-3 text-center mb-4 card-hover">
                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-cog fa-2x"></i>
                    </div>
                    <h5>3. Proses Verifikasi</h5>
                    <p class="text-muted">Admin akan memverifikasi dan memproses surat Anda</p>
                </div>
                <div class="col-md-3 text-center mb-4 card-hover">
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
