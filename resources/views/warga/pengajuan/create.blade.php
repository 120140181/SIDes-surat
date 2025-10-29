{{-- resources/views/warga/pengajuan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ajukan Surat Baru')
@section('page_title', 'Ajukan Surat Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('warga.pengajuan.index') }}">Pengajuan Surat</a></li>
    <li class="breadcrumb-item active">Ajukan Baru</li>
@endsection

@section('active-pengajuan', 'active')
@section('menu-open-pengajuan', 'menu-open')
@section('active-pengajuan-buat', 'active')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Pengajuan Surat</h3>
            </div>
            <form method="POST" action="{{ route('warga.pengajuan.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="surat_jenis_id">Jenis Surat <span class="text-danger">*</span></label>
                        <select class="form-control @error('surat_jenis_id') is-invalid @enderror"
                                id="surat_jenis_id" name="surat_jenis_id" required>
                            <option value="">Pilih Jenis Surat</option>
                            @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis->id }}"
                                    {{ old('surat_jenis_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('surat_jenis_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keperluan">Keperluan / Alasan Pengajuan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('keperluan') is-invalid @enderror"
                                  id="keperluan" name="keperluan" rows="5"
                                  placeholder="Jelaskan keperluan dan alasan pengajuan surat ini..."
                                  required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">
                            Minimal 10 karakter. Jelaskan secara detail untuk mempermudah proses verifikasi.
                        </small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Ajukan Surat
                    </button>
                    <a href="{{ route('warga.pengajuan.index') }}" class="btn btn-default">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Proses Pengajuan:</h6>
                    <ol class="pl-3 mb-0">
                        <li>Ajukan surat melalui form ini</li>
                        <li>Status awal: <span class="badge badge-warning">Menunggu</span></li>
                        <li>Admin akan memverifikasi pengajuan</li>
                        <li>Pantau status di halaman daftar pengajuan</li>
                    </ol>
                </div>

                <div class="alert alert-light">
                    <h6><i class="fas fa-clock"></i> Estimasi Proses:</h6>
                    <ul class="pl-3 mb-0">
                        <li>Verifikasi: 1-2 hari kerja</li>
                        <li>Proses surat: 2-3 hari kerja</li>
                        <li>Surat siap diambil ketika status <span class="badge badge-success">Selesai</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
