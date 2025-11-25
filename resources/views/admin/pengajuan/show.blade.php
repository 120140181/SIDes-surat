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

@push('styles')
<style>
    /* Detail Card Modern */
    .detail-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
        margin-bottom: 20px;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .detail-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .detail-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-table {
        margin: 0;
    }

    .detail-table tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-table tr:last-child {
        border-bottom: none;
    }

    .detail-table th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        padding: 14px 18px;
        border: none;
        width: 40%;
        font-size: 0.9rem;
    }

    .detail-table td {
        padding: 14px 18px;
        color: #2d3748;
        font-weight: 500;
        border: none;
        font-size: 0.9rem;
    }

    .badge-modern {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-idle {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .badge-proses {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-selesai {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .keperluan-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #667eea;
        border-radius: 10px;
        padding: 18px;
        margin-top: 15px;
    }

    .keperluan-box label {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .keperluan-text {
        color: #4a5568;
        line-height: 1.8;
        font-size: 0.95rem;
        word-wrap: break-word;
        word-break: break-word;
        white-space: pre-wrap;
        overflow-wrap: break-word;
    }

    .keterangan-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
        border-radius: 10px;
        padding: 18px;
        margin-top: 15px;
    }

    .keterangan-box label {
        color: #1e40af;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .keterangan-text {
        color: #1e3a8a;
        line-height: 1.8;
        font-size: 0.95rem;
        word-wrap: break-word;
        word-break: break-word;
        white-space: pre-wrap;
        overflow-wrap: break-word;
    }

    /* Update Status Card */
    .update-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .update-card .card-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .update-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        padding: 10px 14px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    select.form-control {
        padding: 12px 14px;
        height: auto;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-back-modern {
        background: white;
        color: #718096;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-back-modern:hover {
        border-color: #cbd5e0;
        color: #4a5568;
        background: #f9fafb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .header-with-back {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Documents Card */
    .documents-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .documents-card .card-header {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .documents-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .document-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .document-item:last-child {
        border-bottom: none;
    }

    .document-item:hover {
        background: #f7fafc;
    }

    .document-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .document-label i {
        font-size: 1.2rem;
        color: #667eea;
    }

    .document-actions {
        display: flex;
        gap: 8px;
    }

    .btn-view-doc {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .btn-view-doc:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-download-doc {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .btn-download-doc:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 233, 123, 0.4);
        color: white;
        text-decoration: none;
    }

    .no-documents {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }

    .no-documents i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .no-documents p {
        margin: 0;
        font-size: 0.95rem;
    }

    /* Warga Info Card */
    .warga-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .warga-card .card-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .warga-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-card .card-header,
        .update-card .card-header,
        .warga-card .card-header {
            padding: 18px 20px;
        }

        .detail-card .card-header h3,
        .update-card .card-header h3,
        .warga-card .card-header h3 {
            font-size: 1.1rem;
        }

        .detail-table th,
        .detail-table td {
            padding: 12px 15px;
            font-size: 0.85rem;
        }

        .keperluan-box,
        .keterangan-box {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .detail-card .card-header h3 i,
        .update-card .card-header h3 i,
        .warga-card .card-header h3 i {
            display: none;
        }

        .detail-table th {
            width: 40%;
            font-size: 0.8rem;
        }

        .detail-table td {
            font-size: 0.85rem;
        }

        .btn-update,
        .btn-back-modern {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header dengan tombol kembali -->
    <div class="detail-card mb-3">
        <div class="card-header">
            <div class="header-with-back">
                <h3 style="margin: 0;">
                    <i class="fas fa-file-alt"></i>
                    Detail Pengajuan Surat
                </h3>
                <div class="d-flex gap-2">
                    <button onclick="confirmDelete()" class="btn btn-danger" style="border-radius: 10px; padding: 10px 18px; font-weight: 600; margin-right: 10px;">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-back-modern">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Detail Pengajuan Card -->
        <div class="col-lg-6">
            <div class="detail-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Informasi Pengajuan
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table detail-table">
                        <tbody>
                            <tr>
                                <th><i class="fas fa-hashtag text-primary"></i> No Pengajuan</th>
                                <td><strong>{{ $pengajuan->id }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-envelope text-info"></i> Jenis Surat</th>
                                <td>{{ $pengajuan->suratJenis->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-info-circle text-warning"></i> Status</th>
                                <td>
                                    @if($pengajuan->status === 'idle')
                                        <span class="badge-modern badge-idle">
                                            <i class="fas fa-clock"></i> Menunggu Persetujuan
                                        </span>
                                    @elseif($pengajuan->status === 'proses')
                                        <span class="badge-modern badge-proses">
                                            <i class="fas fa-spinner fa-spin"></i> Sedang Diproses
                                        </span>
                                    @else
                                        <span class="badge-modern badge-selesai">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-alt text-success"></i> Tanggal Pengajuan</th>
                                <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($pengajuan->tanggal_meninggal)
                            <tr>
                                <th><i class="fas fa-calendar-times text-danger"></i> Tanggal Meninggal</th>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_meninggal)->format('d/m/Y') }}</td>
                            </tr>
                            @endif
                            @if($pengajuan->tpu)
                            <tr>
                                <th><i class="fas fa-map-marker-alt text-danger"></i> TPU</th>
                                <td>{{ $pengajuan->tpu }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Keperluan Box -->
                    <div class="px-4 pb-4">
                        <div class="keperluan-box">
                            <label>
                                <i class="fas fa-edit"></i>
                                Keperluan
                            </label>
                            <div class="keperluan-text">
                                {{ $pengajuan->keperluan ?? 'Tidak ada keterangan keperluan' }}
                            </div>
                        </div>
                    </div>

                    @if($pengajuan->keterangan_admin)
                    <!-- Keterangan Admin Box -->
                    <div class="px-4 pb-4">
                        <div class="keterangan-box">
                            <label>
                                <i class="fas fa-comment-dots"></i>
                                Keterangan Admin
                            </label>
                            <div class="keterangan-text">
                                {{ $pengajuan->keterangan_admin }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Warga Info Card -->
        <div class="col-lg-6">
            <div class="warga-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-user"></i>
                        Informasi Warga
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table detail-table">
                        <tbody>
                            <tr>
                                <th><i class="fas fa-id-card text-primary"></i> NIK</th>
                                <td><strong>{{ $pengajuan->user->nik ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user-circle text-info"></i> Nama Lengkap</th>
                                <td>{{ $pengajuan->user->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone text-success"></i> No Telepon</th>
                                <td>{{ $pengajuan->user->no_telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-birthday-cake text-danger"></i> Tempat, Tgl Lahir</th>
                                <td>{{ $pengajuan->user->tempat_lahir ?? '-' }}, {{ $pengajuan->user->formatted_tanggal_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars text-purple"></i> Jenis Kelamin</th>
                                <td>{{ $pengajuan->user->formatted_jenis_kelamin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-map-marker-alt text-warning"></i> Alamat</th>
                                <td>{{ $pengajuan->user->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Persyaratan Card -->
    <div class="row">
        <div class="col-12">
            <div class="documents-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-paperclip"></i>
                        Dokumen Persyaratan
                    </h3>
                </div>
                <div class="card-body p-0">
                    @php
                        $hasDocuments = false;
                        $dataPersyaratan = is_string($pengajuan->data_persyaratan)
                            ? json_decode($pengajuan->data_persyaratan, true)
                            : $pengajuan->data_persyaratan;

                        // Get persyaratan for this jenis surat
                        $persyaratanList = $pengajuan->suratJenis->persyaratan ?? [];
                    @endphp

                    @if($dataPersyaratan && count($dataPersyaratan) > 0)
                        @foreach($persyaratanList as $persyaratan)
                            @if(isset($dataPersyaratan[$persyaratan->kode]))
                                @php
                                    $hasDocuments = true;
                                    $value = $dataPersyaratan[$persyaratan->kode];
                                    $isFile = ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image');
                                @endphp
                                <div class="document-item">
                                    <div class="document-label">
                                        <i class="fas fa-{{ $persyaratan->tipe === 'image' ? 'image' : ($persyaratan->tipe === 'file' ? 'file-pdf' : 'info-circle') }}"></i>
                                        <span>{{ $persyaratan->nama }}</span>
                                    </div>
                                    @if($isFile)
                                        @php
                                            $fileExists = \Storage::disk('public')->exists($value);
                                            $fileUrl = url('storage/' . $value);
                                        @endphp
                                        <div class="document-actions">
                                            @if($fileExists)
                                                <a href="{{ $fileUrl }}"
                                                   target="_blank"
                                                   class="btn-view-doc">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <a href="{{ $fileUrl }}"
                                                   download
                                                   class="btn-download-doc">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                <span class="text-danger" style="font-size: 0.85rem;">
                                                    <i class="fas fa-exclamation-triangle"></i> File tidak ditemukan
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-muted" style="font-size: 0.9rem;">
                                            {{ $value }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @endif

                    @if(!$hasDocuments)
                        <div class="no-documents">
                            <i class="fas fa-folder-open"></i>
                            <p>Tidak ada dokumen yang diupload untuk pengajuan ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Card -->
    <div class="row">
        <div class="col-12">
            <div class="update-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-edit"></i>
                        Update Status Pengajuan
                    </h3>
                </div>
                <div class="card-body">
                    <form id="formUpdateStatus" action="{{ route('admin.pengajuan.update-status', $pengajuan->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">
                                        <i class="fas fa-toggle-on"></i> Status
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="idle" {{ $pengajuan->status === 'idle' ? 'selected' : '' }}>⏳ Menunggu Persetujuan</option>
                                        <option value="proses" {{ $pengajuan->status === 'proses' ? 'selected' : '' }}>🔄 Sedang Diproses</option>
                                        <option value="selesai" {{ $pengajuan->status === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterangan_admin">
                                        <i class="fas fa-comment"></i> Keterangan (Opsional)
                                    </label>
                                    <textarea class="form-control @error('keterangan_admin') is-invalid @enderror"
                                              id="keterangan_admin" name="keterangan_admin" rows="3"
                                              placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan_admin', $pengajuan->keterangan_admin) }}</textarea>
                                    @error('keterangan_admin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Keterangan ini akan dilihat oleh warga yang mengajukan surat.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-update" onclick="confirmUpdate()">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form untuk delete (hidden) -->
<form id="formDeletePengajuan" action="{{ route('admin.pengajuan.destroy', $pengajuan->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function confirmUpdate() {
    const statusSelect = document.getElementById('status');
    const statusText = statusSelect.options[statusSelect.selectedIndex].text;
    const keterangan = document.getElementById('keterangan_admin').value;

    let html = '<div class="text-left">';
    html += '<p><strong>Status Baru:</strong> ' + statusText + '</p>';
    if (keterangan) {
        html += '<p><strong>Keterangan:</strong> ' + keterangan + '</p>';
    }
    html += '</div>';

    Swal.fire({
        title: 'Konfirmasi Update Status',
        html: html,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Update!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formUpdateStatus').submit();
        }
    });
}

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Pengajuan Surat?',
        html: '<div class="text-left"><p>Apakah Anda yakin ingin menghapus pengajuan ini?</p><p class="text-danger"><strong>Peringatan:</strong> Semua dokumen yang diupload juga akan dihapus secara permanen!</p></div>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formDeletePengajuan').submit();
        }
    });
}
</script>
@endpush
