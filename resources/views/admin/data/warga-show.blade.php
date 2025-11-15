{{-- resources/views/admin/data/warga-show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Warga')
@section('page_title', 'Detail Warga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.data.warga') }}">Data Warga</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('active-data-warga', 'active')

@push('styles')
<style>
    /* Detail Card Modern */
    .detail-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
        margin-bottom: 20px;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .detail-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .detail-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stats-card .card-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .info-card .card-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .riwayat-card .card-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
        padding: 14px 18px;
        border: none;
        width: 40%;
        font-size: 0.9rem;
    }

    .detail-table td {
        padding: 14px 18px;
        color: #2d3748;
        font-weight: 500;
        border: none;
        font-size: 0.9rem;
    }

    .alamat-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #667eea;
        border-radius: 10px;
        padding: 18px;
        margin-top: 15px;
    }

    .alamat-box label {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .alamat-text {
        color: #4a5568;
        line-height: 1.8;
        font-size: 0.95rem;
    }

    .alert-modern {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
        border-radius: 10px;
        padding: 18px;
        margin-top: 15px;
        color: #92400e;
    }

    .alert-modern strong {
        color: #78350f;
    }

    .alert-modern ul {
        margin-bottom: 0;
        margin-top: 10px;
        padding-left: 20px;
    }

    /* Stats List Modern */
    .stats-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .stats-list li {
        padding: 14px 18px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .stats-list li:last-child {
        border-bottom: none;
    }

    .stats-list li:hover {
        background: #f7fafc;
    }

    .stats-list .stat-label {
        color: #4a5568;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .stats-badge {
        padding: 5px 14px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .stats-badge.badge-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stats-badge.badge-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .stats-badge.badge-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .stats-badge.badge-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    /* Riwayat Table */
    .riwayat-table {
        margin: 0;
    }

    .riwayat-table thead {
        background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
    }

    .riwayat-table thead th {
        color: #2d3748;
        font-weight: 700;
        border: none;
        padding: 14px;
        font-size: 0.9rem;
    }

    .riwayat-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .riwayat-table tbody td {
        padding: 14px;
        color: #4a5568;
        border: none;
        font-size: 0.9rem;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-status.badge-idle {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .badge-status.badge-proses {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-status.badge-selesai {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .btn-view-all {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-top: 15px;
    }

    .btn-view-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-back-modern {
        background: white;
        color: #718096;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-back-modern:hover {
        border-color: #cbd5e0;
        color: #4a5568;
        background: #f9fafb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .header-with-back {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-card .card-header {
            padding: 18px 20px;
        }

        .detail-card .card-header h3 {
            font-size: 1.1rem;
        }

        .detail-table th,
        .detail-table td {
            padding: 12px 15px;
            font-size: 0.85rem;
        }

        .alamat-box,
        .alert-modern {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .detail-card .card-header h3 i {
            display: none;
        }

        .detail-table th {
            width: 45%;
            font-size: 0.8rem;
        }

        .detail-table td {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header dengan tombol kembali -->
    <div class="detail-card mb-3">
        <div class="card-header">
            <div class="header-with-back">
                <h3 style="margin: 0;">
                    <i class="fas fa-user-circle"></i>
                    Detail Data Warga
                </h3>
                <a href="{{ route('admin.data.warga') }}" class="btn btn-back-modern">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Data Pribadi -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-user"></i>
                        Data Pribadi
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table detail-table">
                        <tbody>
                            <tr>
                                <th><i class="fas fa-id-card text-primary"></i> NIK</th>
                                <td><strong>{{ $warga->nik }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user-circle text-info"></i> Nama Lengkap</th>
                                <td>{{ $warga->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-birthday-cake text-danger"></i> Tempat, Tanggal Lahir</th>
                                <td>{{ $warga->tempat_lahir }}, {{ $warga->formatted_tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars text-purple"></i> Jenis Kelamin</th>
                                <td>{{ $warga->formatted_jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-pray text-success"></i> Agama</th>
                                <td>{{ $warga->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-briefcase text-warning"></i> Pekerjaan</th>
                                <td>{{ $warga->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-ring text-pink"></i> Status Perkawinan</th>
                                <td>{{ $warga->status_perkawinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-flag text-danger"></i> Kewarganegaraan</th>
                                <td>{{ $warga->kewarganegaraan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone text-success"></i> No. Telepon</th>
                                <td>{{ $warga->no_telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-alt text-info"></i> Tanggal Daftar</th>
                                <td>{{ $warga->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="px-4 pb-4">
                        <div class="alamat-box">
                            <label>
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat Lengkap
                            </label>
                            <div class="alamat-text">
                                {{ $warga->alamat ?? 'Belum diisi' }}
                            </div>
                        </div>

                        @if(!$warga->isProfileComplete())
                        <div class="alert-modern">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Profile belum lengkap!</strong> Data berikut masih kosong:
                            <ul>
                                @if(empty($warga->alamat))<li>Alamat</li>@endif
                                @if(empty($warga->agama))<li>Agama</li>@endif
                                @if(empty($warga->pekerjaan))<li>Pekerjaan</li>@endif
                                @if(empty($warga->status_perkawinan))<li>Status perkawinan</li>@endif
                                @if(empty($warga->no_telepon))<li>No. telepon</li>@endif
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Riwayat Pengajuan -->
            <div class="detail-card riwayat-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-history"></i>
                        Riwayat Pengajuan Surat
                    </h3>
                </div>
                <div class="card-body">
                    @php
                        $riwayatPengajuan = $warga->pengajuanSurat()->with('suratJenis')->latest()->take(5)->get();
                    @endphp

                    @if($riwayatPengajuan->count() > 0)
                        <div class="table-responsive">
                            <table class="table riwayat-table">
                                <thead>
                                    <tr>
                                        <th>Jenis Surat</th>
                                        <th style="width: 140px;">Tanggal</th>
                                        <th style="width: 140px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatPengajuan as $pengajuan)
                                    <tr>
                                        <td><strong>{{ $pengajuan->suratJenis->nama }}</strong></td>
                                        <td>{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ $pengajuan->status }}">
                                                @if($pengajuan->status == 'idle')
                                                    <i class="fas fa-clock"></i> Menunggu
                                                @elseif($pengajuan->status == 'proses')
                                                    <i class="fas fa-spinner"></i> Proses
                                                @else
                                                    <i class="fas fa-check-circle"></i> Selesai
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('admin.pengajuan.index') }}?search={{ $warga->nik }}"
                               class="btn btn-view-all">
                                <i class="fas fa-list"></i> Lihat Semua Pengajuan
                            </a>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada riwayat pengajuan surat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistik Warga -->
            <div class="detail-card stats-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-chart-bar"></i>
                        Statistik
                    </h3>
                </div>
                <div class="card-body p-0">
                    @php
                        $totalPengajuan = $warga->pengajuanSurat()->count();
                        $pengajuanSelesai = $warga->pengajuanSurat()->where('status', 'selesai')->count();
                        $pengajuanProses = $warga->pengajuanSurat()->where('status', 'proses')->count();
                        $pengajuanIdle = $warga->pengajuanSurat()->where('status', 'idle')->count();
                    @endphp

                    <ul class="stats-list">
                        <li>
                            <span class="stat-label">
                                <i class="fas fa-file-alt"></i> Total Pengajuan
                            </span>
                            <span class="stats-badge badge-primary">{{ $totalPengajuan }}</span>
                        </li>
                        <li>
                            <span class="stat-label">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                            <span class="stats-badge badge-success">{{ $pengajuanSelesai }}</span>
                        </li>
                        <li>
                            <span class="stat-label">
                                <i class="fas fa-spinner"></i> Dalam Proses
                            </span>
                            <span class="stats-badge badge-info">{{ $pengajuanProses }}</span>
                        </li>
                        <li>
                            <span class="stat-label">
                                <i class="fas fa-clock"></i> Menunggu
                            </span>
                            <span class="stats-badge badge-warning">{{ $pengajuanIdle }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Info Akun -->
            <div class="detail-card info-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Informasi Akun
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table detail-table">
                        <tbody>
                            <tr>
                                <th><i class="fas fa-user-check text-success"></i> Status Profile</th>
                                <td>
                                    @if($warga->isProfileComplete())
                                        <span class="stats-badge badge-success">
                                            <i class="fas fa-check"></i> Lengkap
                                        </span>
                                    @else
                                        <span class="stats-badge badge-warning">
                                            <i class="fas fa-exclamation"></i> Belum Lengkap
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-sign-in-alt text-info"></i> Terakhir Login</th>
                                <td>
                                    @if($warga->last_login_at)
                                        {{ $warga->last_login_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Belum pernah login</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-plus text-primary"></i> Terdaftar Sejak</th>
                                <td>{{ $warga->created_at->diffForHumans() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
