{{-- resources/views/admin/data/jenis-surat.blade.php --}}
@extends('layouts.app')

@section('title', 'Jenis Surat')
@section('page_title', 'Jenis Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jenis Surat</li>
@endsection

@section('active-jenis-surat', 'active')

@push('styles')
<style>
    /* Modern Card */
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 20px;
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modern-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .modern-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    /* Form Styling */
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
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: #11998e;
        box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1);
    }

    .btn-add {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.4);
        color: white;
    }

    /* Table Modern */
    .modern-table {
        margin: 0;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
    }

    .modern-table thead th {
        color: #2d3748;
        font-weight: 700;
        border: none;
        padding: 16px;
        font-size: 0.9rem;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .modern-table tbody tr:hover {
        background: #f7fafc;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 16px;
        color: #4a5568;
        border: none;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .number-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .count-badge {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .number-plain {
        color: #4a5568;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-edit-modern {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-edit-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .btn-delete-modern {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-delete-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .btn-persyaratan-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-persyaratan-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state p {
        color: #718096;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-card .card-header {
            padding: 18px 20px;
        }

        .modern-card .card-header h3 {
            font-size: 1.1rem;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px;
            font-size: 0.85rem;
        }

        .btn-edit-modern,
        .btn-delete-modern {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .modern-card .card-header h3 i {
            display: none;
        }

        .modern-table thead th:nth-child(3),
        .modern-table tbody td:nth-child(3) {
            display: none;
        }

        .modern-table thead th:nth-child(4),
        .modern-table tbody td:nth-child(4) {
            display: none;
        }
    }
</style>
@endpush

@section('content')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <!-- Form Tambah Jenis Surat -->
            <div class="modern-card form-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-plus-circle"></i>
                        Tambah Jenis Surat Baru
                    </h3>
                </div>
                <div class="card-body">
                    <form id="formTambah" method="POST" action="{{ route('admin.data.jenis-surat-store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama">
                                <i class="fas fa-file-signature"></i> Nama Jenis Surat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama') }}"
                                   placeholder="Contoh: Surat Keterangan Usaha" required>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">
                                Masukkan nama jenis surat yang dapat diajukan warga
                            </small>
                        </div>
                        <button type="button" class="btn btn-add btn-block" onclick="confirmAdd()">
                            <i class="fas fa-plus"></i> Tambah Jenis Surat
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-list"></i>
                        Daftar Jenis Surat
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($jenisSurat->count() > 0)
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Nama Jenis Surat</th>
                                        <th style="width: 160px;">Jumlah Pengajuan</th>
                                        <th style="width: 130px;">Tanggal Dibuat</th>
                                        <th style="width: 200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jenisSurat as $jenis)
                                    <tr>
                                        <td>
                                            <span class="number-plain">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $jenis->nama }}</strong>
                                        </td>
                                        <td>
                                            <span class="count-badge">
                                                {{ $jenis->pengajuanSurat->count() }} pengajuan
                                            </span>
                                        </td>
                                        <td>{{ $jenis->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.data.jenis-surat-persyaratan', $jenis->id) }}"
                                                   class="btn btn-persyaratan-modern"
                                                   title="Kelola Persyaratan">
                                                    <i class="fas fa-list-check"></i> Persyaratan
                                                </a>

                                                <button type="button" class="btn btn-edit-modern"
                                                        onclick="showEditModal('{{ $jenis->id }}', '{{ $jenis->nama }}')">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <button type="button" class="btn btn-delete-modern"
                                                        onclick="confirmDelete('{{ $jenis->id }}', '{{ $jenis->nama }}', {{ $jenis->pengajuanSurat->count() }})">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>

                                            <form id="deleteForm{{ $jenis->id }}" method="POST"
                                                  action="{{ route('admin.data.jenis-surat-destroy', $jenis->id) }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-list"></i>
                            <p>Belum ada jenis surat yang ditambahkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Confirm Add
function confirmAdd() {
    const namaInput = document.getElementById('nama');
    const nama = namaInput.value.trim();

    if (!nama) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Nama jenis surat tidak boleh kosong!',
            confirmButtonColor: '#667eea'
        });
        namaInput.focus();
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Tambah Jenis Surat',
        html: '<div class="text-left"><p><strong>Nama Jenis Surat:</strong><br>' + nama + '</p></div>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#11998e',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Tambahkan!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formTambah').submit();
        }
    });
}

// Show Edit Modal using SweetAlert
function showEditModal(id, namaLama) {
    Swal.fire({
        title: 'Edit Jenis Surat',
        html:
            '<div class="text-left">' +
            '<label for="swal-input" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Nama Jenis Surat</label>' +
            '<input id="swal-input" class="swal2-input" value="' + namaLama + '" style="width: 90%; margin: 0;">' +
            '</div>',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-save"></i> Simpan Perubahan',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        preConfirm: () => {
            const namaBaru = document.getElementById('swal-input').value.trim();
            if (!namaBaru) {
                Swal.showValidationMessage('Nama jenis surat tidak boleh kosong');
            }
            return namaBaru;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const namaBaru = result.value;

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.data.jenis-surat-update", ":id") }}'.replace(':id', id);

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';

            const namaInput = document.createElement('input');
            namaInput.type = 'hidden';
            namaInput.name = 'nama';
            namaInput.value = namaBaru;

            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            form.appendChild(namaInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Confirm Delete
function confirmDelete(id, nama, jumlahPengajuan) {
    let html = '<div class="text-left">';
    html += '<p><strong>Jenis Surat:</strong> ' + nama + '</p>';
    if (jumlahPengajuan > 0) {
        html += '<p class="text-danger"><strong>⚠️ Peringatan:</strong><br>';
        html += 'Terdapat ' + jumlahPengajuan + ' pengajuan yang menggunakan jenis surat ini!</p>';
    }
    html += '</div>';

    Swal.fire({
        title: 'Hapus Jenis Surat?',
        html: html,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + id).submit();
        }
    });
}
</script>
@endpush
