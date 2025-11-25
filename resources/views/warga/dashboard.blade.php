{{-- resources/views/warga/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Warga')
@section('page_title', 'Dashboard Warga')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('active-dashboard', 'active')

@push('styles')
<style>
    /* Modern Dashboard Styles */
    .content-wrapper {
        background: #f8f9fa;
    }

    /* Alert Modern */
    .modern-alert {
        background: linear-gradient(135deg, #fff9e6 0%, #fff 100%);
        border-left: 4px solid #ffc107;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        animation: slideDown 0.5s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-alert .icon-wrapper {
        width: 50px;
        height: 50px;
        background: rgba(255, 193, 7, 0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .modern-alert .icon-wrapper i {
        color: #ffc107;
        font-size: 1.5rem;
    }

    /* Modern Stats Cards */
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

    .stats-card.card-secondary {
        --card-color-1: #a8a8a8;
        --card-color-2: #d5d5d5;
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

    .stats-card:hover .card-footer-link i {
        transform: translateX(5px);
    }

    /* Modern Table Card */
    .modern-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
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

    .modern-table-card .card-header {
        background: white;
        border-bottom: 2px solid #f7fafc;
        padding: 25px;
    }

    .modern-table-card .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .modern-table-card .card-title i {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
    }

    .modern-table-card .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .modern-table-card .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Modern Table */
    .modern-table {
        margin: 0;
    }

    .modern-table thead th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 18px 20px;
        border: none;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .modern-table tbody tr:hover {
        background: #f8fafe;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .modern-table tbody td strong {
        color: #2d3748;
        font-weight: 600;
    }

    /* Modern Badges */
    .modern-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .modern-badge.badge-idle {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        color: #d63031;
    }

    .modern-badge.badge-proses {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
    }

    .modern-badge.badge-selesai {
        background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
        color: white;
    }

    /* Modern Buttons */
    .btn-detail {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 8px;
        padding: 6px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-detail:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Empty State */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state .empty-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }

    .empty-state .empty-icon i {
        font-size: 3rem;
        color: #cbd5e0;
    }

    .empty-state h5 {
        color: #4a5568;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #718096;
        margin-bottom: 25px;
    }

    .empty-state .btn-empty {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .empty-state .btn-empty:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .stats-card {
            margin-bottom: 15px;
        }

        .stats-card .card-number {
            font-size: 2.2rem;
        }

        .stats-card .card-label {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .modern-alert {
            padding: 15px;
        }

        .modern-alert .icon-wrapper {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .modern-alert .icon-wrapper i {
            font-size: 1.2rem;
        }

        .modern-alert h6 {
            font-size: 0.95rem;
        }

        .modern-alert p {
            font-size: 0.85rem !important;
        }

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
            font-size: 0.88rem;
        }

        .stats-card .card-footer-link {
            font-size: 0.85rem;
        }

        .modern-table-card .card-header {
            padding: 20px 15px;
        }

        .modern-table-card .card-title {
            font-size: 1.1rem;
        }

        .modern-table-card .card-title i {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .modern-table-card .btn-add {
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .modern-table thead th {
            padding: 12px 15px;
            font-size: 0.75rem;
        }

        .modern-table tbody td {
            padding: 12px 15px;
            font-size: 0.88rem;
        }

        .modern-badge {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn-detail {
            padding: 5px 12px;
            font-size: 0.85rem;
        }

        .empty-state {
            padding: 40px 15px;
        }

        .empty-state .empty-icon {
            width: 100px;
            height: 100px;
        }

        .empty-state .empty-icon i {
            font-size: 2.5rem;
        }

        .empty-state h5 {
            font-size: 1.1rem;
        }

        .empty-state p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .content-header h1 {
            font-size: 1.3rem !important;
        }

        .modern-alert {
            padding: 12px;
        }

        .modern-alert .icon-wrapper {
            display: none;
        }

        .modern-alert h6 {
            font-size: 0.9rem;
            margin-bottom: 5px !important;
        }

        .modern-alert p {
            font-size: 0.8rem !important;
        }

        .stats-card {
            padding: 18px;
        }

        .stats-card::before {
            height: 3px;
        }

        .stats-card .card-icon {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
            margin-bottom: 12px;
        }

        .stats-card .card-number {
            font-size: 1.8rem;
        }

        .stats-card .card-label {
            font-size: 0.85rem;
            margin-bottom: 12px;
        }

        .stats-card .card-footer-link {
            font-size: 0.8rem;
            padding-top: 12px;
        }

        .modern-table-card .card-header {
            padding: 15px;
            flex-direction: column;
            align-items: flex-start !important;
        }

        .modern-table-card .card-title {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .modern-table-card .card-title i {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
            margin-right: 8px;
        }

        .modern-table-card .btn-add {
            width: 100%;
            padding: 10px 16px;
            font-size: 0.9rem;
        }

        /* Hide beberapa kolom di mobile */
        .modern-table thead th:nth-child(3),
        .modern-table tbody td:nth-child(3) {
            display: none;
        }

        .modern-table thead th {
            padding: 10px 8px;
            font-size: 0.7rem;
        }

        .modern-table tbody td {
            padding: 10px 8px;
            font-size: 0.82rem;
        }

        .modern-table tbody td strong {
            display: block;
            margin-bottom: 3px;
        }

        .modern-badge {
            padding: 5px 10px;
            font-size: 0.75rem;
        }

        .btn-detail {
            padding: 4px 10px;
            font-size: 0.8rem;
        }

        .btn-detail i {
            display: none;
        }

        .empty-state {
            padding: 30px 10px;
        }

        .empty-state .empty-icon {
            width: 80px;
            height: 80px;
        }

        .empty-state .empty-icon i {
            font-size: 2rem;
        }

        .empty-state h5 {
            font-size: 1rem;
        }

        .empty-state p {
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .empty-state .btn-empty {
            padding: 10px 20px;
            font-size: 0.9rem;
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
            padding: 8px 6px;
            font-size: 0.65rem;
        }

        .modern-table tbody td {
            padding: 8px 6px;
            font-size: 0.75rem;
        }

        .modern-badge {
            padding: 4px 8px;
            font-size: 0.7rem;
        }

        .btn-detail {
            padding: 4px 8px;
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
{{-- Alert jika profile belum lengkap --}}
@if(!Auth::user()->isProfileComplete())
<div class="modern-alert">
    <div class="d-flex align-items-center">
        <div class="icon-wrapper">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1 font-weight-bold" style="color: #d97706;">Profile belum lengkap!</h6>
            <p class="mb-0" style="color: #78716c; font-size: 0.95rem;">
                <a href="{{ route('warga.profile.edit') }}" style="color: #d97706; font-weight: 600; text-decoration: none;">
                    <i class="fas fa-user-edit"></i> Lengkapi data profile Anda
                </a>
                untuk mempermudah proses pengajuan surat.
            </p>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 0; margin: 0;">
            <span aria-hidden="true" style="font-size: 1.5rem; color: #a8a29e;">&times;</span>
        </button>
    </div>
</div>
@endif

<div class="row">
    <!-- Stats Card 1 -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card card-info">
            <div class="card-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="card-number">{{ $totalPengajuan }}</div>
            <div class="card-label">Total Pengajuan</div>
            <a href="{{ route('warga.pengajuan.index') }}" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Stats Card 2 -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card card-success">
            <div class="card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-number">{{ $pengajuanSelesai }}</div>
            <div class="card-label">Surat Selesai</div>
            <a href="{{ route('warga.pengajuan.index') }}?status=selesai" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Stats Card 3 -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card card-warning">
            <div class="card-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-number">{{ $pengajuanProses }}</div>
            <div class="card-label">Dalam Proses</div>
            <a href="{{ route('warga.pengajuan.index') }}?status=proses" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Stats Card 4 -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card card-secondary">
            <div class="card-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="card-number">{{ $pengajuanMenunggu }}</div>
            <div class="card-label">Menunggu</div>
            <a href="{{ route('warga.pengajuan.index') }}?status=idle" class="card-footer-link">
                <span>Lihat Detail</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Pengajuan Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card modern-table-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    <span>Pengajuan Terbaru</span>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-add">
                        <i class="fas fa-plus-circle"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-file-alt"></i> Jenis Surat</th>
                                    <th><i class="far fa-calendar"></i> Tanggal Pengajuan</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th class="text-center"><i class="fas fa-cog"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $pengajuan)
                                <tr>
                                    <td>
                                        <strong>{{ $pengajuan->suratJenis->nama }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</div>
                                        <small style="color: #9ca3af;">{{ $pengajuan->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="modern-badge
                                            @if($pengajuan->status == 'idle') badge-idle
                                            @elseif($pengajuan->status == 'proses') badge-proses
                                            @else badge-selesai @endif">
                                            <i class="fas fa-circle" style="font-size: 6px;"></i>
                                            {{ $pengajuan->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('warga.pengajuan.show', $pengajuan->id) }}"
                                           class="btn btn-detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h5>Belum ada pengajuan surat</h5>
                        <p>Mulai ajukan surat pertama Anda sekarang!</p>
                        <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-empty">
                            <i class="fas fa-plus-circle"></i> Ajukan Surat Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
