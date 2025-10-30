{{-- resources/views/admin/data/warga.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Warga')
@section('page_title', 'Data Warga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Warga</li>
@endsection

@section('active-data-warga', 'active')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Warga Terdaftar</h3>
                <div class="card-tools">
                    <form action="{{ route('admin.data.warga') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control float-right"
                               placeholder="Cari nama, NIK, atau alamat..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($warga->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warga as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <code>{{ $item->nik }}</code>
                                    </td>
                                    <td>
                                        <strong>{{ $item->nama_lengkap }}</strong>
                                        @if(!$item->isProfileComplete())
                                            <span class="badge badge-warning badge-sm" title="Profile belum lengkap">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->formatted_jenis_kelamin }}</td>
                                    <td>{{ $item->no_telepon ?? '-' }}</td>
                                    <td>
                                        <span title="{{ $item->alamat }}">
                                            {{ Str::limit($item->alamat, 30) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.data.warga-show', $item->id) }}"
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
                            Menampilkan <strong>{{ $warga->count() }}</strong> dari <strong>{{ $totalWarga }}</strong> warga terdaftar
                        </p>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada warga terdaftar.</p>
                        @if(request('search'))
                            <a href="{{ route('admin.data.warga') }}" class="btn btn-primary">
                                <i class="fas fa-undo"></i> Tampilkan Semua
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
