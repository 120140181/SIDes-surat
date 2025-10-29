{{-- resources/views/warga/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Warga')
@section('page_title', 'Dashboard Warga')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('active-dashboard', 'active')

@section('content')
{{-- Alert jika profile belum lengkap --}}
@if(!Auth::user()->isProfileComplete())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle"></i>
    <strong>Profile belum lengkap!</strong>
    <a href="{{ route('warga.profile.edit') }}" class="alert-link">Lengkapi data profile Anda</a>
    untuk mempermudah proses pengajuan surat.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <!-- Statistik Card -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalPengajuan }}</h3>
                <p>Total Pengajuan</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="{{ route('warga.pengajuan.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $pengajuanSelesai }}</h3>
                <p>Surat Selesai</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('warga.pengajuan.index') }}?status=selesai" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pengajuanProses }}</h3>
                <p>Dalam Proses</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('warga.pengajuan.index') }}?status=proses" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $pengajuanMenunggu }}</h3>
                <p>Menunggu</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <a href="{{ route('warga.pengajuan.index') }}?status=idle" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Pengajuan Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengajuan Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $pengajuan)
                                <tr>
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
                                        <a href="{{ route('warga.pengajuan.show', $pengajuan->id) }}"
                                           class="btn btn-sm btn-outline-primary">
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
                        <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajukan Surat Pertama Anda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
