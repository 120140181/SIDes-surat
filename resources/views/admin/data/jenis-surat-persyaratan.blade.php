{{-- resources/views/admin/data/jenis-surat-persyaratan.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Persyaratan - ' . $jenisSurat->nama)
@section('page_title', 'Kelola Persyaratan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.data.jenis-surat') }}">Jenis Surat</a></li>
    <li class="breadcrumb-item active">Kelola Persyaratan</li>
@endsection

@section('active-jenis-surat', 'active')

@push('styles')
<style>
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .modern-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 18px 24px;
        border: none;
    }

    .modern-card .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-badge {
        background: rgba(255,255,255,0.2);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .form-group {
        margin-bottom: 0 !important;
    }

    .form-group label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    .form-control small, .form-text {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 4px;
        display: block;
    }

    .btn-add-persyaratan {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-persyaratan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(17, 153, 142, 0.35);
        color: white;
    }

    .persyaratan-item {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .persyaratan-item:hover {
        border-color: #667eea;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.12);
        transform: translateY(-2px);
    }

    .persyaratan-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .persyaratan-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
    }

    .badge-wajib {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-opsional {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-tipe {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .persyaratan-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .persyaratan-detail {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-top: 12px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 0.9rem;
        color: #374151;
        font-weight: 500;
    }

    .kode-field {
        background: #e0e7ff;
        color: #4338ca;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        display: inline-block;
    }

    .persyaratan-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }

    .btn-edit-small, .btn-delete-small {
        border: none;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-edit-small {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .btn-edit-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-delete-small {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-delete-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .empty-persyaratan {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-persyaratan i {
        font-size: 3.5rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-persyaratan p {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .btn-back {
        background: white;
        color: #718096;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-back:hover {
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

    .header-title {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .col-lg-4, .col-lg-8 {
            padding-left: 12px;
            padding-right: 12px;
        }

        .persyaratan-header {
            flex-direction: column;
        }

        .persyaratan-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }

    @media (max-width: 767px) {
        .modern-card .card-header {
            padding: 14px 18px;
        }

        .modern-card .card-header h3 {
            font-size: 1rem;
        }

        .info-badge {
            font-size: 0.8rem;
            padding: 5px 12px;
        }

        .form-control, .form-select {
            font-size: 0.9rem;
            padding: 9px 12px;
        }

        .persyaratan-item {
            padding: 14px;
        }

        .persyaratan-title {
            font-size: 0.95rem;
        }

        .btn-edit-small, .btn-delete-small {
            padding: 7px 12px;
            font-size: 0.75rem;
        }

        .persyaratan-actions {
            gap: 5px;
        }
    }

    @media (max-width: 575px) {
        .btn-edit-small span, .btn-delete-small span {
            display: none;
        }

        .btn-edit-small, .btn-delete-small {
            padding: 8px 10px;
        }
    }

    /* Form Spacing Fix */
    .card-body .form-group + .form-group {
        margin-top: 18px !important;
    }

    .card-body .form-group:last-of-type {
        margin-bottom: 20px !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Info -->
    <div class="modern-card">
        <div class="card-header">
            <div class="header-with-back">
                <div class="header-title">
                    <h3 style="margin: 0;">
                        <i class="fas fa-list-check"></i>
                        Persyaratan: {{ $jenisSurat->nama }}
                    </h3>
                    <span class="info-badge">
                        <i class="fas fa-file-alt"></i> {{ $jenisSurat->persyaratan->count() }} Persyaratan
                    </span>
                </div>
                <a href="{{ route('admin.data.jenis-surat') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Tambah Persyaratan -->
        <div class="col-lg-4">
            <div class="modern-card">
                <div class="card-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <h3>
                        <i class="fas fa-plus-circle"></i>
                        Tambah Persyaratan
                    </h3>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <form method="POST" action="{{ route('admin.data.jenis-surat-persyaratan-store', $jenisSurat->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Persyaratan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama') }}"
                                   placeholder="Contoh: Kartu Keluarga" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode">Kode Field <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                   id="kode" name="kode" value="{{ old('kode') }}"
                                   placeholder="Contoh: dokumen_kk" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Format: dokumen_nama_field (lowercase, _ untuk spasi)
                            </small>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipe">Tipe Input <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="file" {{ old('tipe') == 'file' ? 'selected' : '' }}>📄 File (PDF, JPG, PNG)</option>
                                <option value="image" {{ old('tipe') == 'image' ? 'selected' : '' }}>🖼️ Gambar (JPG, PNG)</option>
                                <option value="text" {{ old('tipe') == 'text' ? 'selected' : '' }}>📝 Teks</option>
                                <option value="date" {{ old('tipe') == 'date' ? 'selected' : '' }}>📅 Tanggal</option>
                                <option value="textarea" {{ old('tipe') == 'textarea' ? 'selected' : '' }}>📋 Teks Panjang</option>
                            </select>
                            @error('tipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="wajib">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('wajib') is-invalid @enderror" id="wajib" name="wajib" required>
                                <option value="1" {{ old('wajib') == '1' ? 'selected' : '' }}>⭐ Wajib</option>
                                <option value="0" {{ old('wajib') == '0' ? 'selected' : '' }}>📌 Opsional</option>
                            </select>
                            @error('wajib')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="urutan">Urutan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                   id="urutan" name="urutan" value="{{ old('urutan', $jenisSurat->persyaratan->count() + 1) }}"
                                   min="0" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Angka kecil muncul lebih dulu di form
                            </small>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan <span class="text-muted">(Opsional)</span></label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                      id="keterangan" name="keterangan" rows="3"
                                      placeholder="Contoh: Upload KTP yang masih berlaku">{{ old('keterangan') }}</textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Petunjuk untuk membantu warga
                            </small>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-add-persyaratan w-100">
                            <i class="fas fa-save"></i> Simpan Persyaratan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Persyaratan -->
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-th-list"></i>
                        Daftar Persyaratan
                    </h3>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @if($jenisSurat->persyaratan->count() > 0)
                        @foreach($jenisSurat->persyaratan as $persyaratan)
                        <div class="persyaratan-item">
                            <div class="persyaratan-header">
                                <div style="flex: 1;">
                                    <div class="persyaratan-title">
                                        <span style="color: #667eea;">#{{ $persyaratan->urutan }}</span>
                                        {{ $persyaratan->nama }}
                                    </div>
                                    <div class="persyaratan-badges">
                                        <span class="{{ $persyaratan->wajib ? 'badge-wajib' : 'badge-opsional' }}">
                                            {{ $persyaratan->wajib_label }}
                                        </span>
                                        <span class="badge-tipe">
                                            <i class="fas fa-{{ $persyaratan->tipe == 'file' ? 'file-upload' : ($persyaratan->tipe == 'image' ? 'image' : ($persyaratan->tipe == 'date' ? 'calendar-alt' : ($persyaratan->tipe == 'textarea' ? 'align-left' : 'keyboard'))) }}"></i>
                                            {{ $persyaratan->tipe_label }}
                                        </span>
                                    </div>
                                </div>
                                <div class="persyaratan-actions">
                                    <button type="button" class="btn btn-edit-small"
                                            onclick="showEditModal({{ $persyaratan->id }}, '{{ $persyaratan->nama }}', '{{ $persyaratan->kode }}', '{{ $persyaratan->tipe }}', {{ $persyaratan->wajib }}, {{ $persyaratan->urutan }}, '{{ addslashes($persyaratan->keterangan ?? '') }}')">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button" class="btn btn-delete-small"
                                            onclick="confirmDelete({{ $persyaratan->id }}, '{{ $persyaratan->nama }}')">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </div>

                            <div class="persyaratan-detail">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-database"></i> Kode Field Database
                                    </span>
                                    <span class="detail-value">
                                        <code class="kode-field">{{ $persyaratan->kode }}</code>
                                    </span>
                                </div>
                                @if($persyaratan->keterangan)
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-info-circle"></i> Keterangan
                                    </span>
                                    <span class="detail-value">{{ $persyaratan->keterangan }}</span>
                                </div>
                                @endif
                            </div>

                            <form id="deleteForm{{ $persyaratan->id }}" method="POST"
                                  action="{{ route('admin.data.jenis-surat-persyaratan-destroy', [$jenisSurat->id, $persyaratan->id]) }}"
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-persyaratan">
                            <i class="fas fa-inbox"></i>
                            <p><strong>Belum ada persyaratan yang ditambahkan</strong><br>
                            <span style="font-size: 0.9rem;">Gunakan form di samping untuk menambahkan persyaratan pertama</span></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Persyaratan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="edit_nama">Nama Persyaratan</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_kode">Kode Field</label>
                        <input type="text" class="form-control" id="edit_kode" name="kode" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_tipe">Tipe Input</label>
                        <select class="form-select" id="edit_tipe" name="tipe" required>
                            <option value="file">File (PDF, JPG, PNG)</option>
                            <option value="image">Gambar (JPG, PNG)</option>
                            <option value="text">Teks</option>
                            <option value="date">Tanggal</option>
                            <option value="textarea">Teks Panjang</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_wajib">Status</label>
                        <select class="form-select" id="edit_wajib" name="wajib" required>
                            <option value="1">Wajib</option>
                            <option value="0">Opsional</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_urutan">Urutan</label>
                        <input type="number" class="form-control" id="edit_urutan" name="urutan" min="0" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showEditModal(id, nama, kode, tipe, wajib, urutan, keterangan) {
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kode').value = kode;
    document.getElementById('edit_tipe').value = tipe;
    document.getElementById('edit_wajib').value = wajib ? '1' : '0';
    document.getElementById('edit_urutan').value = urutan;
    document.getElementById('edit_keterangan').value = keterangan || '';

    const form = document.getElementById('editForm');
    form.action = "{{ route('admin.data.jenis-surat-persyaratan-update', [$jenisSurat->id, ':id']) }}".replace(':id', id);

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

function confirmDelete(id, nama) {
    Swal.fire({
        title: 'Hapus Persyaratan?',
        html: `Apakah Anda yakin ingin menghapus persyaratan <strong>"${nama}"</strong>?<br><br>
               <span style="color: #ef4444;">Perhatian: Field ini akan hilang dari form pengajuan!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
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
