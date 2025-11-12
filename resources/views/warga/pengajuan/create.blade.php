{{-- resources/views/warga/pengajuan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ajukan Surat Baru')
@section('page_title', 'Ajukan Surat Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('warga.pengajuan.index') }}">Pengajuan Surat</a></li>
    <li class="breadcrumb-item active">Ajukan Baru</li>
@endsection

@section('active-pengajuan-buat', 'active')

@push('styles')
<style>
    /* Modern Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border: none;
    }

    .form-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-card .card-body {
        padding: 30px;
    }

    .form-group label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
        height: auto;
        min-height: 48px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    select.form-control {
        padding: 12px 16px;
        line-height: 1.5;
    }

    select.form-control option {
        padding: 10px;
        font-size: 1rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-back {
        background: white;
        color: #718096;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        border-color: #cbd5e0;
        color: #4a5568;
        background: #f7fafc;
    }

    /* Info Card */
    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .info-card .card-header {
        background: #f7fafc;
        padding: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .info-card .card-header h3 {
        color: #2d3748;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }

    .info-alert {
        background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
        border-left: 4px solid #667eea;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .info-alert h6 {
        color: #1e40af;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-alert ol,
    .info-alert ul {
        color: #1e3a8a;
        margin: 0;
        padding-left: 20px;
    }

    .info-alert li {
        margin-bottom: 8px;
    }

    .time-alert {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
        border-radius: 10px;
        padding: 20px;
    }

    .time-alert h6 {
        color: #92400e;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .time-alert ul {
        color: #78350f;
        margin: 0;
        padding-left: 20px;
    }

    .time-alert li {
        margin-bottom: 8px;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* ========================================
       RESPONSIVE DESIGN - MOBILE FIRST
       ======================================== */

    /* Tablet Landscape - 992px and below */
    @media (max-width: 992px) {
        .form-card .card-header h3,
        .info-card .card-header h3 {
            font-size: 1.3rem;
        }

        .form-card .card-body,
        .info-card .card-body {
            padding: 25px;
        }

        .form-card .card-footer {
            padding: 18px 25px !important;
        }
    }

    /* Tablet Portrait / Large Phone - 768px and below */
    @media (max-width: 768px) {
        .form-card .card-header h3,
        .info-card .card-header h3 {
            font-size: 1.2rem;
        }

        .form-card .card-header h3 i,
        .info-card .card-header h3 i {
            font-size: 1rem;
        }

        .form-card .card-body,
        .info-card .card-body {
            padding: 20px;
        }

        .form-card .card-footer {
            padding: 15px 20px !important;
        }

        /* Form Controls */
        .form-group label {
            font-size: 0.9rem;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 10px 14px;
        }

        select.form-control {
            padding: 10px 14px;
        }

        .form-text {
            font-size: 0.85rem;
        }

        /* Buttons */
        .btn-submit,
        .btn-back {
            width: 48%;
            padding: 10px 16px;
            font-size: 0.9rem;
        }

        /* Info Sidebar */
        .info-card {
            margin-top: 20px;
        }

        .info-alert h6,
        .time-alert h6 {
            font-size: 0.95rem;
        }

        .info-alert ol,
        .time-alert ul {
            font-size: 0.85rem;
        }

        .info-alert ol li,
        .time-alert ul li {
            margin-bottom: 6px;
        }
    }

    /* Mobile Phone - 576px and below */
    @media (max-width: 576px) {
        .form-card .card-header,
        .info-card .card-header {
            padding: 15px;
        }

        .form-card .card-header h3,
        .info-card .card-header h3 {
            font-size: 1.05rem;
        }

        .form-card .card-header h3 i,
        .info-card .card-header h3 i {
            display: none; /* Hide icons on mobile */
        }

        .form-card .card-body,
        .info-card .card-body {
            padding: 15px;
        }

        .form-card .card-footer {
            padding: 12px 15px !important;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-group label i {
            display: none; /* Hide label icons on mobile */
        }

        .form-control {
            font-size: 0.85rem;
            padding: 10px 12px;
            min-height: 44px;
        }

        select.form-control {
            padding: 10px 12px;
        }

        textarea.form-control {
            min-height: 100px;
        }

        .form-text {
            font-size: 0.8rem;
        }

        .form-text i {
            display: none;
        }

        /* Buttons Full Width */
        .btn-submit,
        .btn-back {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.85rem;
        }

        /* Info Cards */
        .info-card {
            margin-top: 15px;
        }

        .info-alert,
        .time-alert {
            padding: 12px;
        }

        .info-alert h6,
        .time-alert h6 {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .info-alert h6 i,
        .time-alert h6 i {
            font-size: 0.85rem;
        }

        .info-alert ol,
        .time-alert ul {
            font-size: 0.82rem;
            padding-left: 18px;
        }

        .info-alert ol li,
        .time-alert ul li {
            margin-bottom: 5px;
            line-height: 1.5;
        }

        .badge-status {
            padding: 3px 10px;
            font-size: 0.75rem;
        }
    }

    /* Extra Small Devices - 400px and below */
    @media (max-width: 400px) {
        .form-card .card-header h3,
        .info-card .card-header h3 {
            font-size: 0.95rem;
        }

        .form-card .card-body,
        .info-card .card-body {
            padding: 12px;
        }

        .form-card .card-footer {
            padding: 10px 12px !important;
        }

        .form-group label {
            font-size: 0.8rem;
        }

        .form-control {
            font-size: 0.8rem;
            padding: 8px 10px;
        }

        .btn-submit,
        .btn-back {
            padding: 8px 12px;
            font-size: 0.8rem;
        }

        .info-alert,
        .time-alert {
            padding: 10px;
        }

        .info-alert h6,
        .time-alert h6 {
            font-size: 0.85rem;
        }

        .info-alert ol,
        .time-alert ul {
            font-size: 0.78rem;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card form-card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-paper-plane"></i>
                    <span>Form Pengajuan Surat</span>
                </h3>
            </div>
            <form method="POST" action="{{ route('warga.pengajuan.store') }}" id="formPengajuan">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="surat_jenis_id">
                            <i class="fas fa-file-alt text-primary"></i>
                            Jenis Surat <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('surat_jenis_id') is-invalid @enderror"
                                id="surat_jenis_id" name="surat_jenis_id" required>
                            <option value="">-- Pilih Jenis Surat --</option>
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
                        <label for="keperluan">
                            <i class="fas fa-info-circle text-primary"></i>
                            Keperluan / Alasan Pengajuan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('keperluan') is-invalid @enderror"
                                  id="keperluan" name="keperluan" rows="6"
                                  placeholder="Jelaskan keperluan dan alasan pengajuan surat ini dengan detail..."
                                  required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-lightbulb"></i> Minimal 10 karakter. Jelaskan secara detail untuk mempermudah proses verifikasi.
                        </small>
                    </div>
                </div>
                <div class="card-footer" style="background: #f7fafc; padding: 20px 30px;">
                    <button type="button" class="btn btn-submit" onclick="confirmSubmit()">
                        <i class="fas fa-paper-plane"></i> Ajukan Surat
                    </button>
                    <a href="{{ route('warga.pengajuan.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card info-card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Informasi Penting</h3>
            </div>
            <div class="card-body">
                <div class="info-alert">
                    <h6><i class="fas fa-list-ol"></i> Proses Pengajuan:</h6>
                    <ol>
                        <li>Isi form dengan lengkap dan jelas</li>
                        <li>Status awal: <span class="badge badge-warning badge-status">Menunggu</span></li>
                        <li>Admin akan memverifikasi pengajuan Anda</li>
                        <li>Pantau status di menu Daftar Pengajuan</li>
                        <li>Surat dapat diambil saat status <span class="badge badge-success badge-status">Selesai</span></li>
                    </ol>
                </div>

                <div class="time-alert">
                    <h6><i class="fas fa-clock"></i> Estimasi Waktu Proses:</h6>
                    <ul>
                        <li><strong>Verifikasi:</strong> 1-2 hari kerja</li>
                        <li><strong>Pembuatan surat:</strong> 2-3 hari kerja</li>
                        <li><strong>Total estimasi:</strong> 3-5 hari kerja</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmSubmit() {
        const jenisSurat = document.getElementById('surat_jenis_id');
        const keperluan = document.getElementById('keperluan');

        if (!jenisSurat.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Jenis Surat Belum Dipilih!',
                text: 'Silakan pilih jenis surat terlebih dahulu.',
                confirmButtonColor: '#667eea'
            });
            return;
        }

        if (!keperluan.value || keperluan.value.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Keperluan Belum Diisi!',
                text: 'Silakan isi keperluan minimal 10 karakter.',
                confirmButtonColor: '#667eea'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Pengajuan Surat',
            html: `
                <div style="text-align: left; padding: 10px 20px;">
                    <p style="margin-bottom: 15px; color: #4a5568;">Apakah Anda yakin ingin mengajukan surat dengan detail berikut?</p>
                    <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                        <strong style="color: #2d3748;">Jenis Surat:</strong><br>
                        <span style="color: #667eea;">${jenisSurat.options[jenisSurat.selectedIndex].text}</span>
                    </div>
                    <div style="background: #f7fafc; padding: 15px; border-radius: 8px;">
                        <strong style="color: #2d3748;">Keperluan:</strong><br>
                        <span style="color: #4a5568;">${keperluan.value.substring(0, 100)}${keperluan.value.length > 100 ? '...' : ''}</span>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#cbd5e0',
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Ajukan',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            customClass: {
                popup: 'swal-wide'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Mengirim Pengajuan...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                document.getElementById('formPengajuan').submit();
            }
        });
    }
</script>

<style>
    .swal-wide {
        width: 600px !important;
    }
</style>
@endpush
