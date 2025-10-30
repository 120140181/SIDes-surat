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

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pribadi</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">NIK</th>
                                <td>{{ $warga->nik }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $warga->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>{{ $warga->tempat_lahir }}, {{ $warga->formatted_tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $warga->formatted_jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>{{ $warga->agama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Pekerjaan</th>
                                <td>{{ $warga->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Perkawinan</th>
                                <td>{{ $warga->status_perkawinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kewarganegaraan</th>
                                <td>{{ $warga->kewarganegaraan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $warga->no_telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td>{{ $warga->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Alamat Lengkap:</strong></label>
                    <div class="border p-3 bg-light rounded">
                        {{ $warga->alamat ?? 'Belum diisi' }}
                    </div>
                </div>

                @if(!$warga->isProfileComplete())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Profile belum lengkap!</strong> Data berikut masih kosong:
                    <ul class="mb-0 mt-2">
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

        <!-- Riwayat Pengajuan -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Riwayat Pengajuan Surat</h3>
            </div>
            <div class="card-body">
                @php
                    $riwayatPengajuan = $warga->pengajuanSurat()->with('suratJenis')->latest()->take(5)->get();
                @endphp

                @if($riwayatPengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatPengajuan as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->suratJenis->nama }}</td>
                                    <td>{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($pengajuan->status == 'idle') badge-warning
                                            @elseif($pengajuan->status == 'proses') badge-info
                                            @else badge-success @endif">
                                            {{ $pengajuan->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.pengajuan.index') }}?search={{ $warga->nik }}"
                           class="btn btn-sm btn-outline-primary">
                            Lihat Semua Pengajuan
                        </a>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada riwayat pengajuan surat.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Statistik Warga -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik</h3>
            </div>
            <div class="card-body">
                @php
                    $totalPengajuan = $warga->pengajuanSurat()->count();
                    $pengajuanSelesai = $warga->pengajuanSurat()->where('status', 'selesai')->count();
                    $pengajuanProses = $warga->pengajuanSurat()->where('status', 'proses')->count();
                @endphp

                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Total Pengajuan
                        <span class="badge badge-primary badge-pill">{{ $totalPengajuan }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Selesai
                        <span class="badge badge-success badge-pill">{{ $pengajuanSelesai }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Dalam Proses
                        <span class="badge badge-info badge-pill">{{ $pengajuanProses }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Menunggu
                        <span class="badge badge-warning badge-pill">
                            {{ $warga->pengajuanSurat()->where('status', 'idle')->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Akun -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Informasi Akun</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Status Profile</th>
                        <td>
                            @if($warga->isProfileComplete())
                                <span class="badge badge-success">Lengkap</span>
                            @else
                                <span class="badge badge-warning">Belum Lengkap</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Terakhir Login</th>
                        <td>
                            @if($warga->last_login_at)
                                {{ $warga->last_login_at->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Belum pernah login</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Terdaftar Sejak</th>
                        <td>{{ $warga->created_at->diffForHumans() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
