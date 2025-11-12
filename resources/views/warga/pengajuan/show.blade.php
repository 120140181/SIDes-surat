{{-- resources/views/warga/pengajuan/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')
@section('page_title', 'Detail Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('warga.pengajuan.index') }}">Pengajuan Surat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('active-pengajuan-list', 'active')

@push('styles')
<style>
    /* Detail Card Modern */
    .detail-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
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

    .detail-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border: none;
    }

    .detail-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .detail-table {
        margin: 0;
    }

    .detail-table tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-table tr:last-child {
        border-bottom: none;
    }

    .detail-table th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        padding: 16px 20px;
        border: none;
        width: 40%;
    }

    .detail-table td {
        padding: 16px 20px;
        color: #2d3748;
        font-weight: 500;
        border: none;
    }

    .badge-modern {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-modern.badge-idle {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        color: #d63031;
    }

    .badge-modern.badge-proses {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
    }

    .badge-modern.badge-selesai {
        background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
        color: white;
    }

    .keperluan-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #667eea;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .keperluan-box label {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .keperluan-text {
        color: #4a5568;
        line-height: 1.8;
        font-size: 1rem;
    }

    .keterangan-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
        border-radius: 10px;
        padding: 20px;
    }

    .keterangan-box label {
        color: #1e40af;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .keterangan-text {
        color: #1e3a8a;
        line-height: 1.8;
        font-size: 1rem;
    }

    .btn-back-modern {
        background: white;
        color: #718096;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back-modern:hover {
        border-color: #cbd5e0;
        color: #4a5568;
        background: #f7fafc;
        transform: translateX(-3px);
    }

    .status-info {
        padding: 15px 20px;
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .status-info.idle {
        background: #fff9e6;
        color: #d97706;
    }

    .status-info.proses {
        background: #e0f2fe;
        color: #0284c7;
    }

    .status-info.selesai {
        background: #d1fae5;
        color: #059669;
    }

    /* Timeline Card */
    .timeline-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .timeline-card .card-header {
        background: #f7fafc;
        padding: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .timeline-card .card-header h3 {
        color: #2d3748;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modern-timeline {
        padding: 30px 20px;
    }

    .timeline-item-modern {
        position: relative;
        padding-left: 50px;
        padding-bottom: 30px;
    }

    .timeline-item-modern:last-child {
        padding-bottom: 0;
    }

    .timeline-item-modern::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 40px;
        bottom: -10px;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item-modern:last-child::before {
        display: none;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .timeline-icon.idle {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    }

    .timeline-icon.proses {
        background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
    }

    .timeline-icon.selesai {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
    }

    .timeline-icon.inactive {
        background: #cbd5e0;
    }

    .timeline-content {
        margin-top: 5px;
    }

    .timeline-title {
        color: #2d3748;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 5px;
    }

    .timeline-time {
        color: #9ca3af;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .timeline-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .timeline-badge.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* ========================================
       RESPONSIVE DESIGN - MOBILE FIRST
       ======================================== */

    /* Tablet Landscape - 992px and below */
    @media (max-width: 992px) {
        .detail-card .card-header h3,
        .timeline-card .card-header h3 {
            font-size: 1.3rem;
        }

        .detail-card .card-header h3 i,
        .timeline-card .card-header h3 i {
            font-size: 1.1rem;
        }

        .detail-table th,
        .detail-table td {
            font-size: 0.9rem;
        }

        .badge-modern {
            font-size: 0.8rem;
        }

        .btn-back {
            padding: 10px 16px;
            font-size: 0.9rem;
        }

        .timeline-step h6 {
            font-size: 0.95rem;
        }

        .timeline-step p {
            font-size: 0.85rem;
        }
    }

    /* Tablet Portrait / Large Phone - 768px and below */
    @media (max-width: 768px) {
        .detail-card .card-header,
        .timeline-card .card-header {
            padding: 20px 15px;
        }

        .detail-card .card-header h3,
        .timeline-card .card-header h3 {
            font-size: 1.2rem;
        }

        .detail-card .card-header h3 i,
        .timeline-card .card-header h3 i {
            font-size: 1rem;
        }

        .detail-card .card-body,
        .timeline-card .card-body {
            padding: 20px 15px;
        }

        .detail-table th,
        .detail-table td {
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .keperluan-box,
        .keterangan-box {
            padding: 15px;
            margin-top: 15px;
        }

        .keperluan-box h6,
        .keterangan-box h6 {
            font-size: 0.95rem;
        }

        .keperluan-box p,
        .keterangan-box p {
            font-size: 0.85rem;
        }

        .status-info {
            font-size: 0.9rem;
            padding: 12px 15px;
        }

        .btn-back {
            padding: 10px 14px;
            font-size: 0.85rem;
            width: 100%;
        }

        /* Timeline */
        .modern-timeline {
            padding: 20px 10px;
        }

        .timeline-step {
            padding-left: 45px;
        }

        .timeline-icon {
            width: 35px;
            height: 35px;
            left: 0;
        }

        .timeline-icon i {
            font-size: 0.9rem;
        }

        .timeline-step h6 {
            font-size: 0.9rem;
        }

        .timeline-step p {
            font-size: 0.82rem;
        }

        .current-badge {
            font-size: 0.7rem;
            padding: 3px 10px;
        }
    }

    /* Mobile Phone - 576px and below */
    @media (max-width: 576px) {
        .detail-card .card-header,
        .timeline-card .card-header {
            padding: 15px;
        }

        .detail-card .card-header h3,
        .timeline-card .card-header h3 {
            font-size: 1.05rem;
        }

        .detail-card .card-header h3 i,
        .timeline-card .card-header h3 i {
            display: none; /* Hide header icons on mobile */
        }

        .detail-card .card-body,
        .timeline-card .card-body {
            padding: 15px;
        }

        /* Detail Tables */
        .detail-table th {
            width: 42%;
            font-size: 0.82rem;
            padding: 10px 12px;
        }

        .detail-table td {
            font-size: 0.85rem;
            padding: 10px 12px;
        }

        .detail-table th i {
            display: none; /* Hide table icons on mobile */
        }

        /* Badges */
        .badge-modern {
            font-size: 0.75rem;
            padding: 5px 10px;
        }

        .badge-modern i {
            display: none; /* Hide status dot */
        }

        /* Keperluan & Keterangan Boxes */
        .keperluan-box,
        .keterangan-box {
            padding: 12px;
            margin-top: 12px;
        }

        .keperluan-box h6,
        .keterangan-box h6 {
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .keperluan-box h6 i,
        .keterangan-box h6 i {
            font-size: 0.85rem;
        }

        .keperluan-box p,
        .keterangan-box p {
            font-size: 0.82rem;
            line-height: 1.5;
        }

        /* Status Info */
        .status-info {
            font-size: 0.85rem;
            padding: 10px 12px;
        }

        .status-info i {
            font-size: 0.8rem;
        }

        /* Button */
        .btn-back {
            padding: 10px 12px;
            font-size: 0.85rem;
            width: 100%;
        }

        /* Timeline */
        .modern-timeline {
            padding: 15px 8px;
        }

        .timeline-step {
            padding-left: 40px;
            padding-bottom: 15px;
        }

        .timeline-icon {
            width: 32px;
            height: 32px;
            left: 0;
        }

        .timeline-icon i {
            font-size: 0.85rem;
        }

        .timeline-step h6 {
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .timeline-step p {
            font-size: 0.78rem;
            line-height: 1.4;
        }

        .current-badge {
            font-size: 0.65rem;
            padding: 3px 8px;
        }

        /* Card on mobile */
        .timeline-card {
            margin-top: 15px;
        }
    }

    /* Extra Small Devices - 400px and below */
    @media (max-width: 400px) {
        .detail-card .card-header h3,
        .timeline-card .card-header h3 {
            font-size: 0.95rem;
        }

        .detail-card .card-body,
        .timeline-card .card-body {
            padding: 12px;
        }

        .detail-table th {
            font-size: 0.75rem;
            padding: 8px 10px;
        }

        .detail-table td {
            font-size: 0.8rem;
            padding: 8px 10px;
        }

        .keperluan-box,
        .keterangan-box {
            padding: 10px;
        }

        .keperluan-box h6,
        .keterangan-box h6 {
            font-size: 0.85rem;
        }

        .keperluan-box p,
        .keterangan-box p {
            font-size: 0.78rem;
        }

        .btn-back {
            padding: 8px 10px;
            font-size: 0.8rem;
        }

        .timeline-step {
            padding-left: 35px;
        }

        .timeline-icon {
            width: 28px;
            height: 28px;
        }

        .timeline-icon i {
            font-size: 0.75rem;
        }

        .timeline-step h6 {
            font-size: 0.8rem;
        }

        .timeline-step p {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card detail-card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-file-alt"></i>
                    <span>Informasi Pengajuan</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table detail-table">
                            <tr>
                                <th><i class="fas fa-file-alt text-primary"></i> Jenis Surat</th>
                                <td><strong>{{ $pengajuan->suratJenis->nama }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="far fa-calendar text-primary"></i> Tanggal Pengajuan</th>
                                <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-signal text-primary"></i> Status</th>
                                <td>
                                    <span class="badge-modern
                                        @if($pengajuan->status == 'idle') badge-idle
                                        @elseif($pengajuan->status == 'proses') badge-proses
                                        @else badge-selesai @endif">
                                        <i class="fas fa-circle" style="font-size: 6px;"></i>
                                        {{ $pengajuan->status_label }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table detail-table">
                            <tr>
                                <th><i class="fas fa-user text-primary"></i> Nama Pemohon</th>
                                <td>{{ $pengajuan->user->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-id-card text-primary"></i> NIK</th>
                                <td>{{ $pengajuan->user->nik }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-clock text-primary"></i> Terakhir Update</th>
                                <td>{{ $pengajuan->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="keperluan-box">
                    <label>
                        <i class="fas fa-info-circle"></i>
                        Keperluan / Alasan Pengajuan
                    </label>
                    <div class="keperluan-text">
                        {{ $pengajuan->keperluan }}
                    </div>
                </div>

                @if($pengajuan->keterangan_admin)
                <div class="keterangan-box">
                    <label>
                        <i class="fas fa-comment-dots"></i>
                        Keterangan dari Admin
                    </label>
                    <div class="keterangan-text">
                        {{ $pengajuan->keterangan_admin }}
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer" style="background: #f7fafc; padding: 20px 25px; border-top: 2px solid #e2e8f0;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <a href="{{ route('warga.pengajuan.index') }}" class="btn btn-back-modern mb-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>

                    @if($pengajuan->status == 'idle')
                    <span class="status-info idle mb-2">
                        <i class="fas fa-clock"></i>
                        Menunggu verifikasi admin
                    </span>
                    @elseif($pengajuan->status == 'proses')
                    <span class="status-info proses mb-2">
                        <i class="fas fa-cog fa-spin"></i>
                        Surat sedang diproses
                    </span>
                    @else
                    <span class="status-info selesai mb-2">
                        <i class="fas fa-check-circle"></i>
                        Surat siap diambil di kantor desa
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card timeline-card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-tasks"></i>
                    Status Progress
                </h3>
            </div>
            <div class="card-body">
                <div class="modern-timeline">
                    <!-- Step 1: Menunggu -->
                    <div class="timeline-item-modern">
                        <div class="timeline-icon {{ $pengajuan->status == 'idle' ? 'idle' : ($pengajuan->status == 'proses' || $pengajuan->status == 'selesai' ? 'idle' : 'inactive') }}">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Menunggu Verifikasi</div>
                            <div class="timeline-time">
                                <i class="far fa-calendar-alt"></i>
                                {{ $pengajuan->created_at->format('d/m/Y H:i') }}
                            </div>
                            @if($pengajuan->status == 'idle')
                            <span class="timeline-badge active">
                                <i class="fas fa-circle"></i> Status Saat Ini
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Proses -->
                    <div class="timeline-item-modern">
                        <div class="timeline-icon {{ $pengajuan->status == 'proses' ? 'proses' : ($pengajuan->status == 'selesai' ? 'proses' : 'inactive') }}">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Sedang Diproses</div>
                            <div class="timeline-time">
                                @if($pengajuan->status == 'proses' || $pengajuan->status == 'selesai')
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $pengajuan->updated_at->format('d/m/Y H:i') }}
                                @else
                                    <i class="fas fa-minus-circle"></i> Belum sampai tahap ini
                                @endif
                            </div>
                            @if($pengajuan->status == 'proses')
                            <span class="timeline-badge active">
                                <i class="fas fa-circle"></i> Status Saat Ini
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: Selesai -->
                    <div class="timeline-item-modern">
                        <div class="timeline-icon {{ $pengajuan->status == 'selesai' ? 'selesai' : 'inactive' }}">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Selesai - Dapat Diambil</div>
                            <div class="timeline-time">
                                @if($pengajuan->status == 'selesai')
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $pengajuan->updated_at->format('d/m/Y H:i') }}
                                @else
                                    <i class="fas fa-minus-circle"></i> Belum sampai tahap ini
                                @endif
                            </div>
                            @if($pengajuan->status == 'selesai')
                            <span class="timeline-badge active">
                                <i class="fas fa-circle"></i> Status Saat Ini
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
