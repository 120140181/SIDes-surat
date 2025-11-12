{{-- resources/views/warga/pengajuan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Pengajuan Surat')
@section('page_title', 'Daftar Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Daftar Pengajuan</li>
@endsection

@section('active-pengajuan-list', 'active')

@push('styles')
<style>
    /* Modern Table Card */
    .modern-card {
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

    .modern-card .card-header {
        background: white;
        border-bottom: 2px solid #f7fafc;
        padding: 25px;
    }

    .modern-card .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .modern-card .card-title i {
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

    .btn-add-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .btn-add-modern:hover {
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

    /* Modern Buttons */
    .btn-detail-modern {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 8px;
        padding: 6px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-detail-modern:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Empty State */
    .empty-state-modern {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-state-modern .empty-icon {
        width: 140px;
        height: 140px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .empty-state-modern .empty-icon i {
        font-size: 4rem;
        color: #cbd5e0;
    }

    .empty-state-modern h5 {
        color: #4a5568;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    .empty-state-modern p {
        color: #718096;
        margin-bottom: 30px;
        font-size: 1rem;
    }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* ========================================
       RESPONSIVE DESIGN - MOBILE FIRST
       ======================================== */

    /* Tablet Landscape - 992px and below */
    @media (max-width: 992px) {
        .modern-card .card-header {
            padding: 25px;
        }

        .modern-card .card-header h3 {
            font-size: 1.3rem;
        }

        .btn-add-modern {
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .modern-table thead th {
            font-size: 0.9rem;
            padding: 14px;
        }

        .modern-table tbody td {
            font-size: 0.9rem;
            padding: 16px 14px;
        }

        .number-badge {
            width: 26px;
            height: 26px;
            font-size: 0.8rem;
        }
    }

    /* Tablet Portrait / Large Phone - 768px and below */
    @media (max-width: 768px) {
        .modern-card .card-header {
            padding: 20px;
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }

        .modern-card .card-header h3 {
            font-size: 1.2rem;
        }

        .modern-card .card-header h3 i {
            font-size: 1rem;
        }

        .modern-card .card-header .card-tools {
            width: 100%;
        }

        .btn-add-modern {
            width: 100%;
            justify-content: center;
            padding: 10px 16px;
            font-size: 0.9rem;
        }

        .modern-table thead th {
            font-size: 0.85rem;
            padding: 12px 10px;
        }

        .modern-table tbody td {
            font-size: 0.85rem;
            padding: 14px 10px;
        }

        /* Hide keperluan column on tablets */
        .modern-table thead th:nth-child(3),
        .modern-table tbody td:nth-child(3) {
            display: none;
        }

        .badge-modern {
            padding: 5px 10px;
            font-size: 0.75rem;
        }

        .badge-modern i {
            font-size: 5px;
        }

        .btn-detail-modern {
            padding: 5px 12px;
            font-size: 0.85rem;
        }

        .number-badge {
            width: 24px;
            height: 24px;
            font-size: 0.75rem;
        }

        /* Empty State */
        .empty-state-modern {
            padding: 40px 20px;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
        }

        .empty-icon i {
            font-size: 3rem;
        }

        .empty-state-modern h5 {
            font-size: 1.1rem;
        }

        .empty-state-modern p {
            font-size: 0.9rem;
            margin-bottom: 25px;
        }

        .empty-state-modern .btn-add-modern {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }

    /* Mobile Phone - 576px and below */
    @media (max-width: 576px) {
        .modern-card .card-header {
            padding: 15px;
            gap: 12px;
        }

        .modern-card .card-header h3 {
            font-size: 1.05rem;
        }

        .modern-card .card-header h3 i {
            display: none; /* Hide icon on mobile */
        }

        .btn-add-modern {
            padding: 10px 14px;
            font-size: 0.85rem;
        }

        .btn-add-modern i {
            font-size: 0.85rem;
        }

        .modern-table thead th {
            font-size: 0.75rem;
            padding: 10px 8px;
        }

        .modern-table tbody td {
            font-size: 0.8rem;
            padding: 12px 8px;
        }

        /* Hide tanggal column on mobile */
        .modern-table thead th:nth-child(4),
        .modern-table tbody td:nth-child(4) {
            display: none;
        }

        /* Hide keterangan admin column on mobile */
        .modern-table thead th:nth-child(5),
        .modern-table tbody td:nth-child(5) {
            display: none;
        }

        /* Hide icons in table headers */
        .modern-table thead th i {
            display: none;
        }

        /* Adjust column widths for mobile */
        .modern-table thead th:nth-child(1), /* # */
        .modern-table tbody td:nth-child(1) {
            width: 35px;
            padding: 10px 5px;
        }

        .modern-table thead th:nth-child(2), /* Jenis Surat */
        .modern-table tbody td:nth-child(2) {
            font-size: 0.82rem;
        }

        .modern-table thead th:nth-child(6), /* Status */
        .modern-table tbody td:nth-child(6) {
            padding: 10px 6px;
        }

        .modern-table thead th:nth-child(7), /* Aksi */
        .modern-table tbody td:nth-child(7) {
            width: 70px;
            padding: 10px 5px;
        }

        .badge-modern {
            padding: 4px 8px;
            font-size: 0.7rem;
            display: inline-block;
        }

        .badge-modern i {
            display: none; /* Hide status dot on mobile */
        }

        .btn-detail-modern {
            padding: 5px 8px;
            font-size: 0.75rem;
        }

        .btn-detail-modern i {
            display: none; /* Hide eye icon, show only "Detail" text */
        }

        .number-badge {
            width: 22px;
            height: 22px;
            font-size: 0.7rem;
            border-radius: 6px;
        }

        /* Empty State Mobile */
        .empty-state-modern {
            padding: 30px 15px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .empty-icon i {
            font-size: 2.5rem;
        }

        .empty-state-modern h5 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .empty-state-modern p {
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .empty-state-modern .btn-add-modern {
            padding: 10px 16px;
            font-size: 0.85rem;
            width: 100%;
        }
    }

    /* Extra Small Devices - 400px and below */
    @media (max-width: 400px) {
        .modern-card .card-header h3 {
            font-size: 0.95rem;
        }

        .btn-add-modern {
            font-size: 0.8rem;
            padding: 8px 12px;
        }

        .modern-table thead th {
            font-size: 0.7rem;
            padding: 8px 5px;
        }

        .modern-table tbody td {
            font-size: 0.75rem;
            padding: 10px 5px;
        }

        .badge-modern {
            padding: 3px 6px;
            font-size: 0.65rem;
        }

        .btn-detail-modern {
            padding: 4px 6px;
            font-size: 0.7rem;
        }

        .number-badge {
            width: 20px;
            height: 20px;
            font-size: 0.65rem;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    <span>Semua Pengajuan Surat</span>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-add-modern">
                        <i class="fas fa-plus-circle"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th><i class="fas fa-file-alt"></i> Jenis Surat</th>
                                    <th><i class="fas fa-info-circle"></i> Keperluan</th>
                                    <th><i class="far fa-calendar"></i> Tanggal</th>
                                    <th><i class="fas fa-signal"></i> Status</th>
                                    <th><i class="fas fa-sticky-note"></i> Keterangan</th>
                                    <th class="text-center" style="width: 120px;"><i class="fas fa-cog"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan as $item)
                                <tr>
                                    <td>
                                        <span class="number-badge">{{ $loop->iteration }}</span>
                                    </td>
                                    <td><strong>{{ $item->suratJenis->nama }}</strong></td>
                                    <td>{{ Str::limit($item->keperluan, 50) }}</td>
                                    <td>
                                        <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #9ca3af;">{{ $item->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="badge-modern
                                            @if($item->status == 'idle') badge-idle
                                            @elseif($item->status == 'proses') badge-proses
                                            @else badge-selesai @endif">
                                            <i class="fas fa-circle" style="font-size: 6px;"></i>
                                            {{ $item->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->keterangan_admin)
                                            <small>{{ Str::limit($item->keterangan_admin, 30) }}</small>
                                        @else
                                            <span style="color: #cbd5e0;">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('warga.pengajuan.show', $item->id) }}"
                                           class="btn btn-detail-modern btn-sm">
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
                        <p>Anda belum mengajukan surat apapun. Mulai ajukan surat pertama Anda!</p>
                        <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-add-modern">
                            <i class="fas fa-plus-circle"></i> Ajukan Surat Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
