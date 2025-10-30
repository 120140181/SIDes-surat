{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('active-dashboard', 'active')

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalWarga }}</h3>
                <p>Total Warga</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.data.warga') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalPengajuan }}</h3>
                <p>Total Pengajuan</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="{{ route('admin.pengajuan.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pengajuanIdle }}</h3>
                <p>Menunggu Verifikasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.pengajuan.index') }}?status=idle" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $pengajuanSelesai }}</h3>
                <p>Surat Selesai</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('admin.pengajuan.index') }}?status=selesai" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pengajuan Terbaru -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengajuan Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-list"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Warga</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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
                                        <span class="badge
                                            @if($pengajuan->status == 'idle') badge-warning
                                            @elseif($pengajuan->status == 'proses') badge-info
                                            @else badge-success @endif">
                                            {{ $pengajuan->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada pengajuan surat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik Cepat</h3>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Dalam Proses
                        <span class="badge badge-info badge-pill">{{ $pengajuanProses }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Menunggu Verifikasi
                        <span class="badge badge-warning badge-pill">{{ $pengajuanIdle }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Selesai Hari Ini
                        <span class="badge badge-success badge-pill">{{ $selesaiHariIni }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Total Bulan Ini
                        <span class="badge badge-primary badge-pill">{{ $totalBulanIni }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Aksi Cepat</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.pengajuan.index') }}?status=idle" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-tasks"></i> Verifikasi Pengajuan
                </a>
                <a href="{{ route('admin.data.warga') }}" class="btn btn-info btn-block mb-2">
                    <i class="fas fa-users"></i> Data Warga
                </a>
                <a href="{{ route('admin.data.jenis-surat') }}" class="btn btn-success btn-block">
                    <i class="fas fa-list"></i> Jenis Surat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
