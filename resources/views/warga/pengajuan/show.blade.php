{{-- resources/views/warga/pengajuan/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')
@section('page_title', 'Detail Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('warga.pengajuan.index') }}">Pengajuan Surat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('active-pengajuan', 'active')
@section('menu-open-pengajuan', 'menu-open')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pengajuan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Jenis Surat</th>
                                <td>{{ $pengajuan->suratJenis->nama }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge
                                        @if($pengajuan->status == 'idle') badge-warning
                                        @elseif($pengajuan->status == 'proses') badge-info
                                        @else badge-success @endif">
                                        {{ $pengajuan->status_label }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Nama Pemohon</th>
                                <td>{{ $pengajuan->user->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $pengajuan->user->nik }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diupdate</th>
                                <td>{{ $pengajuan->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Keperluan / Alasan Pengajuan:</strong></label>
                    <div class="border p-3 bg-light rounded">
                        {{ $pengajuan->keperluan }}
                    </div>
                </div>

                @if($pengajuan->keterangan_admin)
                <div class="form-group">
                    <label><strong>Keterangan dari Admin:</strong></label>
                    <div class="border p-3 bg-info text-white rounded">
                        <i class="fas fa-info-circle"></i> {{ $pengajuan->keterangan_admin }}
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('warga.pengajuan.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>

                @if($pengajuan->status == 'idle')
                <span class="float-right text-muted">
                    <i class="fas fa-clock"></i> Menunggu proses verifikasi oleh admin
                </span>
                @elseif($pengajuan->status == 'proses')
                <span class="float-right text-info">
                    <i class="fas fa-cog fa-spin"></i> Surat sedang diproses
                </span>
                @else
                <span class="float-right text-success">
                    <i class="fas fa-check-circle"></i> Surat siap diambil di kantor desa
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status Progres</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @php
                        $steps = [
                            'idle' => ['icon' => 'clock', 'class' => 'bg-warning', 'text' => 'Menunggu Verifikasi'],
                            'proses' => ['icon' => 'cog', 'class' => 'bg-info', 'text' => 'Sedang Diproses'],
                            'selesai' => ['icon' => 'check', 'class' => 'bg-success', 'text' => 'Selesai - Dapat Diambil']
                        ];
                    @endphp

                    @foreach($steps as $status => $step)
                    <div class="time-label">
                        <span class="{{ $step['class'] }}">
                            <i class="fas fa-{{ $step['icon'] }}"></i>
                        </span>
                    </div>

                    <div>
                        <i class="fas fa-{{ $step['icon'] }} {{ $step['class'] }}"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i>
                                @if($pengajuan->status == $status)
                                    {{ $pengajuan->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </span>
                            <h3 class="timeline-header no-border">
                                {{ $step['text'] }}
                                @if($pengajuan->status == $status)
                                    <span class="badge {{ $step['class'] }}">Status Saat Ini</span>
                                @endif
                            </h3>
                        </div>
                    </div>
                    @endforeach

                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
