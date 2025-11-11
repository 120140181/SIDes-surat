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
<div class="alert alert-warning alert-dismissible fade show shadow-sm border-0" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
        <div>
            <strong>Profile belum lengkap!</strong><br>
            <small>
                <a href="{{ route('warga.profile.edit') }}" class="alert-link">
                    <i class="fas fa-user-edit"></i> Lengkapi data profile Anda
                </a>
                untuk mempermudah proses pengajuan surat.
            </small>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <!-- Statistik Card dengan Gradient -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-info shadow-sm hover-scale">
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
        <div class="small-box bg-gradient-success shadow-sm hover-scale">
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
        <div class="small-box bg-gradient-warning shadow-sm hover-scale">
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
        <div class="small-box bg-gradient-secondary shadow-sm hover-scale">
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
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-history text-primary"></i> Pengajuan Terbaru
                </h3>
                <div class="card-tools">
                    <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0"><i class="fas fa-file-alt"></i> Jenis Surat</th>
                                    <th class="border-0"><i class="fas fa-calendar"></i> Tanggal Pengajuan</th>
                                    <th class="border-0"><i class="fas fa-info-circle"></i> Status</th>
                                    <th class="border-0 text-center"><i class="fas fa-cog"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $pengajuan)
                                <tr>
                                    <td class="align-middle">
                                        <strong>{{ $pengajuan->suratJenis->nama }}</strong>
                                    </td>
                                    <td class="align-middle">
                                        <i class="far fa-clock text-muted"></i>
                                        {{ $pengajuan->created_at->format('d/m/Y H:i') }}
                                        <br>
                                        <small class="text-muted">{{ $pengajuan->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-pill px-3 py-2
                                            @if($pengajuan->status == 'idle') badge-warning
                                            @elseif($pengajuan->status == 'proses') badge-info
                                            @else badge-success @endif">
                                            <i class="fas fa-circle" style="font-size: 8px;"></i>
                                            {{ $pengajuan->status_label }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
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
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-inbox fa-4x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted">Belum ada pengajuan surat</h5>
                        <p class="text-muted mb-4">Mulai ajukan surat pertama Anda sekarang!</p>
                        <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus-circle"></i> Ajukan Surat Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
