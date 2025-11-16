{{-- resources/views/welcome.blade.php --}}
@extends('layouts.guest')

@section('title', 'Sistem Surat Desa Gedung Harapan')

@push('styles')
<style>
    /* Enhanced Hero Section */
    .hero-section {
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        top: -200px;
        right: -200px;
        animation: float 8s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
        bottom: -150px;
        left: -150px;
        animation: float 10s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(20px, -20px) rotate(5deg); }
    }

    .hero-content {
        position: relative;
        z-index: 1;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-icon {
        font-size: 15rem;
        animation: floatIcon 6s ease-in-out infinite;
        filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .btn-hero {
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid white;
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* Enhanced Feature Cards */
    .feature-card {
        border-radius: 20px;
        transition: all 0.4s ease;
        background: white;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102,126,234,0.1), transparent);
        transition: left 0.5s ease;
    }

    .feature-card:hover::before {
        left: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(102,126,234,0.3) !important;
        border-color: #667eea;
    }

    .feature-icon {
        font-size: 4rem !important;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.2) rotate(5deg);
    }

    .section-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
    }

    /* Status Card Enhancement */
    .status-card {
        border-radius: 25px;
        background: white;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        border: none;
        overflow: hidden;
        position: relative;
    }

    .status-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
        background-size: 200% 100%;
        animation: shimmer 3s ease infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .status-indicator {
        position: relative;
    }

    .status-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid currentColor;
        opacity: 0.3;
        animation: pulse 2s ease infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
        50% { transform: translate(-50%, -50%) scale(1.3); opacity: 0; }
    }

    /* Steps Enhancement */
    .step-card {
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
    }

    .step-card:hover {
        transform: translateY(-15px);
    }

    .step-circle {
        width: 100px;
        height: 100px;
        transition: all 0.4s ease;
        position: relative;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    .step-circle::before {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border-radius: 50%;
        background: linear-gradient(135deg, currentColor, transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .step-card:hover .step-circle {
        transform: rotate(360deg);
    }

    .step-card:hover .step-circle::before {
        opacity: 0.3;
    }

    /* Smooth Scroll Animation */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Alert Enhancements */
    .alert {
        border-radius: 15px;
        border: none;
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="display-4 fw-bold mb-4" style="animation-delay: 0.2s;">
                    Sistem Informasi Surat Desa Gedung Harapan
                </h1>
                <p class="lead mb-4" style="animation-delay: 0.4s; opacity: 0.95;">
                    Layanan pengurusan surat menyurat secara online yang cepat, mudah, dan transparan untuk warga Desa Gedung Harapan.
                </p>
                <div class="d-flex gap-3 flex-wrap" style="animation-delay: 0.6s;">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-hero">
                        <i class="bi bi-person-plus me-2"></i> Daftar Akun
                    </a>
                    <a href="#layanan" class="btn btn-outline-light btn-lg btn-hero">
                        <i class="bi bi-info-circle me-2"></i> Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="bi bi-envelope-paper hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="layanan" class="py-5 fade-in" style="margin-bottom: 80px;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">
                <i class="bi bi-stars me-2"></i>Layanan Kami
            </span>
            <h2 class="fw-bold display-5 mt-3">Layanan Surat Lengkap</h2>
            <p class="text-muted lead">Berbagai jenis layanan surat yang dapat diajukan secara online</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 feature-card shadow-sm">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-file-text feature-icon mb-4 d-block"></i>
                        <h4 class="card-title fw-bold mb-3">Surat Keterangan</h4>
                        <p class="card-text text-muted">
                            Surat keterangan domisili, tidak mampu, usaha, dan lainnya untuk keperluan administratif.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 feature-card shadow-sm">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-person-vcard feature-icon mb-4 d-block"></i>
                        <h4 class="card-title fw-bold mb-3">Surat Pengantar</h4>
                        <p class="card-text text-muted">
                            Surat pengantar untuk berbagai keperluan seperti pembuatan KTP, KK, dan dokumen kependudukan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 feature-card shadow-sm">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-building feature-icon mb-4 d-block"></i>
                        <h4 class="card-title fw-bold mb-3">Surat Izin</h4>
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
<section class="py-5 fade-in" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-bottom: 80px;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-white text-primary px-4 py-2 mb-3" style="font-size: 1rem;">
                <i class="fas fa-circle" style="font-size: 0.5rem; color: #28a745;"></i>
                <span class="ms-2">Live Status</span>
            </span>
            <h2 class="text-white fw-bold display-5">Status Layanan Saat Ini</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card status-card">
                    <div class="card-body p-5">
                        <div class="row text-center align-items-center">
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

                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-4">
                                        <div class="status-indicator {{ $isOpen ? 'bg-success' : 'bg-danger' }}" style="width: 80px; height: 80px;">
                                            <i class="fas fa-{{ $isOpen ? 'check' : 'times' }}" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                    <div class="text-start">
                                        <h2 class="mb-2 fw-bold {{ $isOpen ? 'text-success' : 'text-danger' }}">
                                            {{ $isOpen ? 'BUKA' : 'TUTUP' }}
                                        </h2>
                                        <p class="text-muted mb-0 fw-medium">
                                            @if($isOpen)
                                                Layanan sedang berjalan
                                            @else
                                                Layanan sedang tutup
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="p-4 bg-light rounded-4">
                                    <h3 class="text-primary mb-2 fw-bold" style="font-size: 2.5rem;">
                                        <i class="fas fa-clock me-2"></i>
                                        {{ $now->format('H:i') }}
                                    </h3>
                                    <p class="text-muted mb-0 fw-medium">
                                        {{ $now->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if(!$isOpen && $nextOpen)
                        <div class="alert alert-warning mt-4 text-center shadow-sm">
                            <i class="fas fa-info-circle me-2" style="font-size: 1.2rem;"></i>
                            <strong>Kantor desa akan buka kembali pada
                            {{ $nextOpen->translatedFormat('l, d F Y') }}
                            pukul {{ $nextOpen->format('H:i') }}</strong>
                        </div>
                        @endif

                        @if($isOpen)
                        <div class="alert alert-success mt-4 text-center shadow-sm">
                            <i class="fas fa-check-circle me-2" style="font-size: 1.2rem;"></i>
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
<section class="py-5 my-5 fade-in" style="margin-bottom: 100px !important;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">
                <i class="bi bi-diagram-3 me-2"></i>Cara Kerja
            </span>
            <h2 class="fw-bold display-5 mt-3">Mudah & Cepat</h2>
            <p class="text-muted lead">Hanya 4 langkah untuk mendapatkan surat Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 text-center step-card">
                <div class="step-circle bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4">
                    <i class="fas fa-user-plus fa-3x"></i>
                </div>
                <div class="badge bg-primary mb-3" style="font-size: 0.9rem;">Langkah 1</div>
                <h5 class="fw-bold mb-3">Daftar/Login</h5>
                <p class="text-muted">Daftar sebagai warga atau login ke akun Anda dengan mudah</p>
            </div>
            <div class="col-md-3 text-center step-card">
                <div class="step-circle bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4">
                    <i class="fas fa-edit fa-3x"></i>
                </div>
                <div class="badge bg-success mb-3" style="font-size: 0.9rem;">Langkah 2</div>
                <h5 class="fw-bold mb-3">Ajukan Surat</h5>
                <p class="text-muted">Isi form pengajuan surat dengan data yang diperlukan</p>
            </div>
            <div class="col-md-3 text-center step-card">
                <div class="step-circle bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4">
                    <i class="fas fa-cog fa-3x fa-spin"></i>
                </div>
                <div class="badge bg-info mb-3" style="font-size: 0.9rem;">Langkah 3</div>
                <h5 class="fw-bold mb-3">Proses Verifikasi</h5>
                <p class="text-muted">Admin akan memverifikasi dan memproses surat Anda</p>
            </div>
            <div class="col-md-3 text-center step-card">
                <div class="step-circle bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
                <div class="badge bg-warning mb-3" style="font-size: 0.9rem;">Langkah 4</div>
                <h5 class="fw-bold mb-3">Selesai & Ambil</h5>
                <p class="text-muted">Ambil surat fisik di kantor desa ketika status selesai</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Intersection Observer for fade-in animations
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endpush
@endsection
