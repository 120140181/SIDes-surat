{{-- resources/views/warga/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Profile')
@section('page_title', 'Edit Profile')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('warga.profile.show') }}">Profile</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('active-profile', 'active')

@push('styles')
<style>
    /* Form Card Modern */
    .form-card-edit {
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

    .form-card-edit .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border: none;
    }

    .form-card-edit .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-card-edit .card-body {
        padding: 30px;
    }

    .form-group label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control:disabled,
    .form-control.bg-light {
        background: #f7fafc;
        color: #718096;
    }

    select.form-control {
        cursor: pointer;
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-cancel {
        background: white;
        color: #718096;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        border-color: #cbd5e0;
        color: #4a5568;
        background: #f7fafc;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .form-card-edit .card-header h3 {
            font-size: 1rem;
        }

        .form-card-edit .card-body {
            padding: 20px 15px;
        }

        .form-group label {
            font-size: 0.9rem;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 10px 14px;
        }

        .btn-save,
        .btn-cancel {
            padding: 10px 20px;
            font-size: 0.95rem;
            width: 100%;
            margin-bottom: 10px;
        }

        .card-footer {
            padding: 15px 20px !important;
        }
    }

    @media (max-width: 576px) {
        .form-card-edit .card-header {
            padding: 20px 15px;
        }

        .form-card-edit .card-header h3 {
            font-size: 0.95rem;
        }

        .form-card-edit .card-header h3 i {
            font-size: 0.9rem;
        }

        .form-group label i {
            display: none;
        }

        .form-control {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card form-card-edit">
            <div class="card-header">
                <h3>
                    <i class="fas fa-user-edit"></i>
                    <span>Form Edit Profile</span>
                </h3>
            </div>
            <form method="POST" action="{{ route('warga.profile.update') }}" id="formProfile">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">
                                    <i class="fas fa-id-card text-primary"></i>
                                    NIK
                                </label>
                                <input type="text" class="form-control bg-light" id="nik"
                                       value="{{ $user->nik }}" readonly>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> NIK tidak dapat diubah
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="nama_lengkap">
                                    <i class="fas fa-user text-primary"></i>
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       id="nama_lengkap" name="nama_lengkap"
                                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                       placeholder="Masukkan nama lengkap" required>
                                @error('nama_lengkap')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tempat_lahir">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    Tempat Lahir <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                       id="tempat_lahir" name="tempat_lahir"
                                       value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                                       placeholder="Masukkan tempat lahir" required>
                                @error('tempat_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tanggal_lahir">
                                    <i class="fas fa-birthday-cake text-primary"></i>
                                    Tanggal Lahir <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                       id="tanggal_lahir" name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir', $user->tanggal_lahir->format('Y-m-d')) }}" required>
                                @error('tanggal_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_kelamin">
                                    <i class="fas fa-venus-mars text-primary"></i>
                                    Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="agama">
                                    <i class="fas fa-pray text-primary"></i>
                                    Agama <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('agama') is-invalid @enderror"
                                        id="agama" name="agama" required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama', $user->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama', $user->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama', $user->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama', $user->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama', $user->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama', $user->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan">
                                    <i class="fas fa-briefcase text-primary"></i>
                                    Pekerjaan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                       id="pekerjaan" name="pekerjaan"
                                       value="{{ old('pekerjaan', $user->pekerjaan) }}"
                                       placeholder="Masukkan pekerjaan" required>
                                @error('pekerjaan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status_perkawinan">
                                    <i class="fas fa-ring text-primary"></i>
                                    Status Perkawinan <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('status_perkawinan') is-invalid @enderror"
                                        id="status_perkawinan" name="status_perkawinan" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Kawin" {{ old('status_perkawinan', $user->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan', $user->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan', $user->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan', $user->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                @error('status_perkawinan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kewarganegaraan">
                                    <i class="fas fa-flag text-primary"></i>
                                    Kewarganegaraan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('kewarganegaraan') is-invalid @enderror"
                                       id="kewarganegaraan" name="kewarganegaraan"
                                       value="{{ old('kewarganegaraan', $user->kewarganegaraan) }}"
                                       placeholder="Masukkan kewarganegaraan" required>
                                @error('kewarganegaraan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_telepon">
                                    <i class="fas fa-phone text-primary"></i>
                                    No. Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                       id="no_telepon" name="no_telepon"
                                       value="{{ old('no_telepon', $user->no_telepon) }}"
                                       placeholder="Masukkan nomor telepon" required>
                                @error('no_telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">
                                    <i class="fas fa-home text-primary"></i>
                                    Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                          id="alamat" name="alamat" rows="5"
                                          placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" style="background: #f7fafc; padding: 20px 30px;">
                    <button type="button" class="btn btn-save" onclick="confirmSave()">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('warga.profile.show') }}" class="btn btn-cancel">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmSave() {
        // Validate required fields
        const requiredFields = [
            { id: 'nama_lengkap', label: 'Nama Lengkap' },
            { id: 'tempat_lahir', label: 'Tempat Lahir' },
            { id: 'tanggal_lahir', label: 'Tanggal Lahir' },
            { id: 'jenis_kelamin', label: 'Jenis Kelamin' },
            { id: 'agama', label: 'Agama' },
            { id: 'pekerjaan', label: 'Pekerjaan' },
            { id: 'status_perkawinan', label: 'Status Perkawinan' },
            { id: 'kewarganegaraan', label: 'Kewarganegaraan' },
            { id: 'no_telepon', label: 'No. Telepon' },
            { id: 'alamat', label: 'Alamat' }
        ];

        for (let field of requiredFields) {
            const element = document.getElementById(field.id);
            if (!element.value) {
                Swal.fire({
                    icon: 'warning',
                    title: `${field.label} Belum Diisi!`,
                    text: `Silakan isi ${field.label} terlebih dahulu.`,
                    confirmButtonColor: '#667eea'
                });
                element.focus();
                return;
            }
        }

        Swal.fire({
            title: 'Konfirmasi Simpan Perubahan',
            html: `
                <div style="text-align: left; padding: 10px;">
                    <p style="color: #4a5568; margin-bottom: 15px;">Apakah Anda yakin ingin menyimpan perubahan data profile?</p>
                    <div style="background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b;">
                        <strong style="color: #92400e;"><i class="fas fa-exclamation-triangle"></i> Perhatian:</strong><br>
                        <span style="color: #78350f; font-size: 0.9rem;">Data yang diubah akan mempengaruhi pengajuan surat selanjutnya.</span>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#cbd5e0',
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            customClass: {
                popup: 'swal-wide'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan Perubahan...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                document.getElementById('formProfile').submit();
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
