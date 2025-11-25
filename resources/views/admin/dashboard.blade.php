{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('active-dashboard', 'active')

@push('styles')
<style>
    /* Modern Stats Cards - Same as Warga Dashboard */
    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color-1), var(--card-color-2));
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .stats-card.card-info {
        --card-color-1: #4facfe;
        --card-color-2: #00f2fe;
    }

    .stats-card.card-success {
        --card-color-1: #43e97b;
        --card-color-2: #38f9d7;
    }

    .stats-card.card-warning {
        --card-color-1: #fa709a;
        --card-color-2: #fee140;
    }

    .stats-card.card-purple {
        --card-color-1: #667eea;
        --card-color-2: #764ba2;
    }

    .stats-card .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 15px;
        background: linear-gradient(135deg, var(--card-color-1), var(--card-color-2));
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .stats-card .card-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
        line-height: 1;
    }

    .stats-card .card-label {
        font-size: 0.95rem;
        color: #718096;
        font-weight: 500;
        margin-bottom: 15px;
    }

    .stats-card .card-footer-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #4a5568;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
        transition: color 0.3s ease;
    }

    .stats-card .card-footer-link:hover {
        color: var(--card-color-1);
    }

    .stats-card .card-footer-link i {
        transition: transform 0.3s ease;
    }

    .stats-card .card-footer-link:hover i {
        transform: translateX(3px);
    }

    /* Modern Table Card */
    .modern-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .modern-table-card .card-header .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modern-table-card .card-header .card-title i {
        font-size: 1.2rem;
    }

    .modern-table-card .card-header .card-tools {
        margin-left: auto;
    }

    .modern-table-card .btn-header {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .modern-table-card .btn-header:hover {
        background: white;
        color: #667eea;
        transform: translateY(-2px);
    }

    .modern-table {
        margin: 0;
    }

    .modern-table thead th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border: none;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-table tbody tr:hover {
        background: #f7fafc;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        color: #2d3748;
        border: none;
        font-size: 0.9rem;
    }

    .modern-table tbody td strong {
        color: #1a202c;
        font-weight: 600;
    }

    .modern-table tbody td small {
        color: #718096;
        font-size: 0.85rem;
    }

    /* Modern Badges */
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
    }

    .badge-idle {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .badge-proses {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-selesai {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .btn-detail-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-detail-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Quick Stats Sidebar */
    .quick-stats-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        margin-bottom: 20px;
        animation: fadeInUp 0.6s ease 0.2s backwards;
    }

    .quick-stats-card .card-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 20px;
        border: none;
    }

    .quick-stats-card .card-header h3,
    .quick-stats-card .card-header .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-stats-card .list-group-item {
        border: none;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .quick-stats-card .list-group-item:last-child {
        border-bottom: none;
    }

    .quick-stats-card .list-group-item:hover {
        background: #f7fafc;
        padding-left: 25px;
    }

    .quick-stats-card .badge-pill {
        padding: 8px 15px;
        font-weight: 600;
        font-size: 0.9rem;
        border-radius: 20px;
    }

    /* Quick Actions Card */
    .quick-actions-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        animation: fadeInUp 0.6s ease 0.3s backwards;
    }

    .quick-actions-card .card-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 20px;
        border: none;
    }

    .quick-actions-card .card-header h3,
    .quick-actions-card .card-header .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-actions-card .card-body {
        padding: 20px;
    }

    .btn-action-modern {
        width: 100%;
        padding: 12px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .btn-action-modern:last-child {
        margin-bottom: 0;
    }

    .btn-action-modern.btn-warning-custom {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .btn-action-modern.btn-info-custom {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .btn-action-modern.btn-success-custom {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .btn-action-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    /* Empty State */
    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s ease-in-out infinite;
    }

    .empty-icon i {
        font-size: 3.5rem;
        color: #cbd5e0;
    }

    .empty-state-modern h5 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.3rem;
    }

    .empty-state-modern p {
        color: #718096;
        margin-bottom: 0;
        font-size: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .stats-card {
            padding: 20px;
        }

        .stats-card .card-icon {
            width: 55px;
            height: 55px;
            font-size: 1.6rem;
        }

        .stats-card .card-number {
            font-size: 2.2rem;
        }

        .stats-card .card-label {
            font-size: 0.9rem;
        }

        .modern-table-card .card-header {
            padding: 18px 20px;
        }

        .modern-table-card .card-header .card-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 768px) {
        .stats-card {
            padding: 20px;
        }

        .stats-card .card-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .stats-card .card-number {
            font-size: 2rem;
        }

        .stats-card .card-label {
            font-size: 0.85rem;
        }

        .modern-table-card .card-header {
            padding: 20px;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .modern-table-card .card-header h3 {
            font-size: 1.2rem;
        }

        .modern-table thead th {
            padding: 12px 15px;
            font-size: 0.8rem;
        }

        .modern-table tbody td {
            padding: 15px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .stats-card {
            padding: 18px;
        }

        .stats-card .card-icon {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
        }

        .stats-card .card-number {
            font-size: 1.8rem;
        }

        .stats-card .card-label {
            font-size: 0.8rem;
            margin-bottom: 12px;
        }

        .stats-card .card-footer-link {
            font-size: 0.85rem;
            padding-top: 12px;
        }

        .modern-table-card .card-header h3 {
            font-size: 1.05rem;
        }

        .modern-table-card .card-header h3 i {
            display: none;
        }

        .modern-table thead th {
            padding: 10px 12px;
            font-size: 0.75rem;
        }

        .modern-table tbody td {
            padding: 12px;
            font-size: 0.85rem;
        }

        .modern-table tbody td:nth-child(4) {
            display: none; /* Hide tanggal column on mobile */
        }

        .modern-table thead th:nth-child(4) {
            display: none;
        }

        .btn-detail-modern {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .btn-detail-modern i {
            display: none;
        }

        .quick-stats-card,
        .quick-actions-card {
            margin-top: 15px;
        }
    }

    @media (max-width: 400px) {
        .stats-card {
            padding: 15px;
        }

        .stats-card .card-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .stats-card .card-number {
            font-size: 1.5rem;
        }

        .stats-card .card-label {
            font-size: 0.75rem;
        }

        .modern-table thead th {
            padding: 8px 10px;
            font-size: 0.7rem;
        }

        .modern-table tbody td {
            padding: 10px;
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card card-info">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-number">{{ $totalWarga }}</div>
            <div class="card-label">Total Warga Terdaftar</div>
            <a href="{{ route('admin.data.warga') }}" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card card-success">
            <div class="card-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="card-number">{{ $totalPengajuan }}</div>
            <div class="card-label">Total Pengajuan Surat</div>
            <a href="{{ route('admin.pengajuan.index') }}" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card card-warning">
            <div class="card-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-number">{{ $pengajuanIdle }}</div>
            <div class="card-label">Menunggu Verifikasi</div>
            <a href="{{ route('admin.pengajuan.index') }}?status=idle" class="card-footer-link">
                <span>Verifikasi Sekarang</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card card-purple">
            <div class="card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-number">{{ $pengajuanSelesai }}</div>
            <div class="card-label">Surat Selesai</div>
            <a href="{{ route('admin.pengajuan.index') }}?status=selesai" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pengajuan Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="modern-table-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    <span>Pengajuan Terbaru</span>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn-header">
                        <i class="fas fa-list"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user"></i> Warga</th>
                                    <th><i class="fas fa-file-alt"></i> Jenis Surat</th>
                                    <th><i class="far fa-calendar"></i> Tanggal</th>
                                    <th><i class="fas fa-signal"></i> Status</th>
                                    <th><i class="fas fa-cog"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $pengajuan)
                                <tr>
                                    <td>
                                        <strong>{{ $pengajuan->user->nama_lengkap }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $pengajuan->user->nik }}</small>
                                    </td>
                                    <td>{{ $pengajuan->suratJenis->nama }}</td>
                                    <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge-modern
                                            @if($pengajuan->status == 'idle') badge-idle
                                            @elseif($pengajuan->status == 'proses') badge-proses
                                            @else badge-selesai @endif">
                                            <i class="fas fa-circle" style="font-size: 6px;"></i>
                                            {{ $pengajuan->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}"
                                           class="btn-detail-modern">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state-modern">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h5>Belum Ada Pengajuan Surat</h5>
                        <p>Belum ada pengajuan surat yang masuk saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats & Actions -->
    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="quick-stats-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    <span>Statistik Cepat</span>
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <span><i class="fas fa-spinner text-info me-2"></i> Dalam Proses</span>
                        <span class="badge badge-info badge-pill">{{ $pengajuanProses }}</span>
                    </div>
                    <div class="list-group-item">
                        <span><i class="fas fa-clock text-warning me-2"></i> Menunggu Verifikasi</span>
                        <span class="badge badge-warning badge-pill">{{ $pengajuanIdle }}</span>
                    </div>
                    <div class="list-group-item">
                        <span><i class="fas fa-check text-success me-2"></i> Selesai Hari Ini</span>
                        <span class="badge badge-success badge-pill">{{ $selesaiHariIni }}</span>
                    </div>
                    <div class="list-group-item">
                        <span><i class="fas fa-calendar text-primary me-2"></i> Total Bulan Ini</span>
                        <span class="badge badge-primary badge-pill">{{ $totalBulanIni }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt"></i>
                    <span>Aksi Cepat</span>
                </h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.pengajuan.index') }}?status=idle" class="btn btn-action-modern btn-warning-custom">
                    <i class="fas fa-tasks"></i> Verifikasi Pengajuan
                </a>
                <a href="{{ route('admin.data.warga') }}" class="btn btn-action-modern btn-info-custom">
                    <i class="fas fa-users"></i> Data Warga
                </a>
                <a href="{{ route('admin.data.jenis-surat') }}" class="btn btn-action-modern btn-success-custom">
                    <i class="fas fa-list"></i> Kelola Jenis Surat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
