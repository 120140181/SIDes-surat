{{-- resources/views/warga/pengajuan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Pengajuan Surat')
@section('page_title', 'Daftar Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Daftar Pengajuan</li>
@endsection

@section('active-pengajuan', 'active')
@section('menu-open-pengajuan', 'menu-open')
@section('active-pengajuan-list', 'active')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Semua Pengajuan Surat</h3>
                <div class="card-tools">
                    <a href="{{ route('warga.pengajuan.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($pengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Surat</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->suratJenis->nama }}</td>
                                    <td>{{ Str::limit($item->keperluan, 50) }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($item->status == 'idle') badge-warning
                                            @elseif($item->status == 'proses') badge-info
                                            @else badge-success @endif">
                                            {{ $item->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->keterangan_admin)
                                            <small>{{ Str::limit($item->keterangan_admin, 30) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('warga.pengajuan.show', $item->id) }}"
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
