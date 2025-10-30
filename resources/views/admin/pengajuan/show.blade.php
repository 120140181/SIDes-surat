{{-- resources/views/admin/pengajuan/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')
@section('page_title', 'Detail Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Pengajuan Surat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('active-pengajuan', 'active')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Informasi Pengajuan -->
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
                                <th>No. Telepon</th>
                                <td>{{ $pengajuan->user->no_telepon ?? '-' }}</td>
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
                    <label><strong>Keterangan Admin:</strong></label>
                    <div class="border p-3 bg-info text-white rounded">
                        <i class="fas fa-info-circle"></i> {{ $pengajuan->keterangan_admin }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Status -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Update Status Pengajuan</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pengajuan.update-status', $pengajuan->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="idle" {{ $pengajuan->status == 'idle' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ $pengajuan->status == 'proses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai" {{ $pengajuan->status == 'selesai' ? 'selected' : '' }}>Selesai - Dapat Diambil</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan_admin">Keterangan (Opsional)</label>
                        <textarea class="form-control @error('keterangan_admin') is-invalid @enderror"
                                  id="keterangan_admin" name="keterangan_admin"
                                  rows="3" placeholder="Berikan keterangan untuk warga...">{{ old('keterangan_admin', $pengajuan->keterangan_admin) }}</textarea>
                        @error('keterangan_admin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">
                            Keterangan ini akan dilihat oleh warga yang mengajukan surat.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Informasi Warga -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Warga</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nama Lengkap</th>
                        <td>{{ $pengajuan->user->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $pengajuan->user->nik }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tgl Lahir</th>
                        <td>{{ $pengajuan->user->tempat_lahir }}, {{ $pengajuan->user->formatted_tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $pengajuan->user->formatted_jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $pengajuan->user->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $pengajuan->user->pekerjaan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="card mt-3">
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
