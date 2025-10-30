{{-- resources/views/admin/data/jenis-surat.blade.php --}}
@extends('layouts.app')

@section('title', 'Jenis Surat')
@section('page_title', 'Jenis Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jenis Surat</li>
@endsection

@section('active-jenis-surat', 'active')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Form Tambah Jenis Surat -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Jenis Surat Baru</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.data.jenis-surat-store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Jenis Surat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama') }}"
                               placeholder="Contoh: Surat Keterangan Usaha" required>
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i> Tambah Jenis Surat
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Jenis Surat</h3>
            </div>
            <div class="card-body">
                @if($jenisSurat->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Jenis Surat</th>
                                    <th>Jumlah Pengajuan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jenisSurat as $jenis)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $jenis->nama }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $jenis->pengajuanSurat->count() }} pengajuan
                                        </span>
                                    </td>
                                    <td>{{ $jenis->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"
                                                data-toggle="modal" data-target="#editModal{{ $jenis->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.data.jenis-surat-destroy', $jenis->id) }}"
                                              class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jenis surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $jenis->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Jenis Surat</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.data.jenis-surat-update', $jenis->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="nama_edit{{ $jenis->id }}">Nama Jenis Surat</label>
                                                        <input type="text" class="form-control"
                                                               id="nama_edit{{ $jenis->id }}" name="nama"
                                                               value="{{ $jenis->nama }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada jenis surat yang ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
