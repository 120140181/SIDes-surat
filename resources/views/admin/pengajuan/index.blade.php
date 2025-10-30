{{-- resources/views/admin/pengajuan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengajuan Surat')
@section('page_title', 'Kelola Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengajuan Surat</li>
@endsection

@section('active-pengajuan', 'active')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pengajuan Surat</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <select class="form-control" onchange="window.location.href='?status='+this.value">
                            <option value="">Semua Status</option>
                            <option value="idle" {{ request('status') == 'idle' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($pengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Warga</th>
                                    <th>Jenis Surat</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $item->user->nama_lengkap }}</strong>
                                        <br>
                                        <small class="text-muted">NIK: {{ $item->user->nik }}</small>
                                        <br>
                                        <small class="text-muted">Telp: {{ $item->user->no_telepon ?? '-' }}</small>
                                    </td>
                                    <td>{{ $item->suratJenis->nama }}</td>
                                    <td>
                                        <span title="{{ $item->keperluan }}">
                                            {{ Str::limit($item->keperluan, 50) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($item->status == 'idle') badge-warning
                                            @elseif($item->status == 'proses') badge-info
                                            @else badge-success @endif">
                                            {{ $item->status_label }}
                                        </span>
                                        @if($item->keterangan_admin)
                                            <br>
                                            <small class="text-muted" title="{{ $item->keterangan_admin }}">
                                                {{ Str::limit($item->keterangan_admin, 30) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $item->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <p class="text-muted">
                            Menampilkan <strong>{{ $pengajuan->count() }}</strong> dari <strong>{{ $totalPengajuan }}</strong> pengajuan
                        </p>
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
</div>
@endsection
