{{-- resources/views/warga/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Profile Saya')
@section('page_title', 'Profile Saya')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('active-profile', 'active')

@push('styles')
<style>
    /* Profile Card Modern */
    .profile-card {
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

    .profile-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border: none;
    }

    .profile-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-edit-profile {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
        border-radius: 10px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-edit-profile:hover {
        background: white;
        color: #667eea;
    }

    .profile-table {
        margin: 0;
    }

    .profile-table tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .profile-table tr:last-child {
        border-bottom: none;
    }

    .profile-table th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        padding: 16px 20px;
        border: none;
    }

    .profile-table td {
        padding: 16px 20px;
        color: #2d3748;
        font-weight: 500;
        border: none;
    }

    /* Password Card */
    .password-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .password-card .card-header {
        background: #f7fafc;
        padding: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .password-card .card-header h3 {
        color: #2d3748;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .password-card .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .password-card .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .btn-change-password {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-change-password:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        color: white;
    }

    /* Info Card */
    .info-card-custom {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .info-card-custom .card-header {
        background: #f7fafc;
        padding: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .info-card-custom .card-header h3 {
        color: #2d3748;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-alert-custom {
        background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
        border-left: 4px solid #667eea;
        border-radius: 10px;
        padding: 20px;
    }

    .info-alert-custom h6 {
        color: #1e40af;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-alert-custom ul {
        color: #1e3a8a;
        margin: 0;
        padding-left: 20px;
    }

    .info-alert-custom li {
        margin-bottom: 8px;
    }

    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .profile-card .card-header h3 {
            font-size: 1rem;
        }

        .profile-card .card-header h3 i {
            font-size: 1rem;
        }

        .btn-edit-profile {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .profile-table th,
        .profile-table td {
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .profile-table th {
            width: 45%;
        }

        .password-card .form-control,
        .info-alert-custom {
            font-size: 0.9rem;
        }

        .btn-change-password {
            padding: 10px;
            font-size: 0.95rem;
        }

        .password-card .card-body,
        .info-card-custom .card-body {
            padding: 20px 15px;
        }
    }

    @media (max-width: 576px) {
        .profile-card .card-header,
        .password-card .card-header,
        .info-card-custom .card-header {
            padding: 20px 15px;
        }

        .profile-card .card-body {
            padding: 0;
        }

        .profile-table th i {
            display: none;
        }

        .profile-table th {
            width: 40%;
            font-size: 0.85rem;
        }

        .profile-table td {
            font-size: 0.85rem;
            word-break: break-word;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card profile-card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-user-circle"></i>
                    <span>Data Pribadi</span>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('warga.profile.edit') }}" class="btn btn-edit-profile btn-sm">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table profile-table">
                            <tr>
                                <th width="40%"><i class="fas fa-id-card text-primary"></i> NIK</th>
                                <td>{{ $user->nik }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user text-primary"></i> Nama Lengkap</th>
                                <td>{{ $user->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-birthday-cake text-primary"></i> Tempat, Tgl Lahir</th>
                                <td>{{ $user->tempat_lahir }}, {{ $user->formatted_tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars text-primary"></i> Jenis Kelamin</th>
                                <td>{{ $user->formatted_jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-pray text-primary"></i> Agama</th>
                                <td>{{ $user->agama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table profile-table">
                            <tr>
                                <th width="40%"><i class="fas fa-briefcase text-primary"></i> Pekerjaan</th>
                                <td>{{ $user->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-ring text-primary"></i> Status Perkawinan</th>
                                <td>{{ $user->status_perkawinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-flag text-primary"></i> Kewarganegaraan</th>
                                <td>{{ $user->kewarganegaraan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone text-primary"></i> No. Telepon</th>
                                <td>{{ $user->no_telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-home text-primary"></i> Alamat</th>
                                <td>{{ $user->alamat ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Update Password Card -->
        <div class="card password-card">
            <div class="card-header">
                <h3><i class="fas fa-key"></i> Ubah Password</h3>
            </div>
            <form method="POST" action="{{ route('warga.profile.update-password') }}" id="formPassword">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password Saat Ini
                        </label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                               id="current_password" name="current_password" placeholder="Masukkan password saat ini" required>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password Baru
                        </label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                               id="new_password" name="new_password" placeholder="Masukkan password baru" required>
                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i>
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" class="form-control"
                               id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi password baru" required>
                    </div>
                </div>
                <div class="card-footer" style="background: white; padding: 20px; border-top: 0;">
                    <button type="button" class="btn btn-change-password" onclick="confirmPasswordChange()">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="card info-card-custom">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Informasi</h3>
            </div>
            <div class="card-body">
                <div class="info-alert-custom">
                    <h6><i class="fas fa-exclamation-circle"></i> Penting:</h6>
                    <ul>
                        <li>Pastikan data profile selalu update dan akurat</li>
                        <li>Data ini akan digunakan dalam semua pengajuan surat</li>
                        <li>Perubahan data akan mempengaruhi pengajuan baru</li>
                        <li>Hubungi admin jika ada kesalahan data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmPasswordChange() {
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('new_password_confirmation');

        if (!currentPassword.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Password Saat Ini Belum Diisi!',
                text: 'Silakan isi password saat ini terlebih dahulu.',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        if (!newPassword.value || newPassword.value.length < 8) {
            Swal.fire({
                icon: 'warning',
                title: 'Password Baru Terlalu Pendek!',
                text: 'Password baru harus minimal 8 karakter.',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        if (newPassword.value !== confirmPassword.value) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok!',
                text: 'Password baru dan konfirmasi password tidak sama.',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Ubah Password',
            text: 'Apakah Anda yakin ingin mengubah password?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#cbd5e0',
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Ubah',
            cancelButtonText: '<i class="fas fa-times"></i> Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formPassword').submit();
            }
        });
    }
</script>
@endpush
