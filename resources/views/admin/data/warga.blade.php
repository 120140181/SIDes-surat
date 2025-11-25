{{-- resources/views/admin/data/warga.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Warga')
@section('page_title', 'Data Warga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Warga</li>
@endsection

@section('active-data-warga', 'active')

@push('styles')
<style>
    /* Modern Card */
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .modern-card .card-title {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modern-card .card-tools {
        margin-left: auto;
    }

    /* Search Bar */
    .search-form {
        position: relative;
        width: 320px;
    }

    .search-form input {
        border-radius: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 10px 90px 10px 40px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .search-form input::placeholder {
        color: rgba(255,255,255,0.7);
    }

    .search-form input:focus {
        background: white;
        color: #2d3748;
        border-color: white;
        outline: none;
        box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
    }

    .search-form input:focus::placeholder {
        color: #a0aec0;
    }

    .search-form .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.7);
        pointer-events: none;
        font-size: 0.9rem;
    }

    .search-form input:focus ~ .search-icon {
        color: #a0aec0;
    }

    .search-form .btn-clear {
        position: absolute;
        margin-right: 10px;
        right: 50px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.7);
        width: 24px;
        height: 24px;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 1rem;
        padding: 0;
        cursor: pointer;
    }

    .search-form .btn-clear.show {
        display: flex;
    }

    .search-form .btn-clear:hover {
        color: rgba(239, 68, 68, 0.9);
        transform: translateY(-50%) scale(1.2);
    }

    .search-form .btn-search {
        position: absolute;
        right: 4px;
        top: 4px;
        bottom: 4px;
        background: rgba(255,255,255,0.25);
        border: none;
        border-radius: 16px;
        color: white;
        padding: 0 18px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .search-form .btn-search:hover {
        background: rgba(255,255,255,0.35);
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
        transform: scale(1.005);
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

    .nik-code {
        background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #2d3748;
        border-left: 3px solid #667eea;
    }

    .profile-incomplete-badge {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 5px;
    }

    .btn-detail-modern {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-detail-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
        color: white;
    }

    /* Stats Info */
    .stats-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
        border-radius: 8px;
        padding: 12px 16px;
        margin-top: 15px;
        color: #1e3a8a;
        font-weight: 600;
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
        margin-bottom: 20px;
    }

    .btn-reset {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .modern-table thead th:nth-child(5),
        .modern-table tbody td:nth-child(5) {
            display: none;
        }

        .modern-table thead th:nth-child(6),
        .modern-table tbody td:nth-child(6) {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .modern-card .card-header {
            padding: 18px 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .modern-card .card-title {
            font-size: 1.1rem;
        }

        .modern-card .card-tools {
            width: 100%;
            margin-left: 0;
            margin-top: 15px;
        }

        .search-form {
            width: 100%;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px;
            font-size: 0.85rem;
        }

        .modern-table thead th:nth-child(7),
        .modern-table tbody td:nth-child(7) {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .modern-card .card-title i {
            display: none;
        }

        .modern-table thead th:nth-child(4),
        .modern-table tbody td:nth-child(4) {
            display: none;
        }

        .btn-detail-modern {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .btn-detail-modern i {
            display: none;
        }
    }
</style>
@endpush

@section('content')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Daftar Warga Terdaftar
                    </h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.data.warga') }}" method="GET" class="search-form">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control" id="searchInput"
                                   placeholder="Cari nama, NIK, atau alamat..." value="{{ request('search') }}">
                            @if(request('search'))
                            <a href="{{ route('admin.data.warga') }}" class="btn btn-clear show" title="Hapus pencarian">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            <button type="submit" class="btn btn-search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($warga->count() > 0)
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th style="width: 150px;">NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th style="width: 130px;">Jenis Kelamin</th>
                                        <th style="width: 140px;">No. Telepon</th>
                                        <th>Alamat</th>
                                        <th style="width: 130px;">Tanggal Daftar</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warga as $item)
                                    <tr>
                                        <td>
                                            <span class="number-badge">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="nik-code">{{ $item->nik }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $item->nama_lengkap }}</strong>
                                            @if(!$item->isProfileComplete())
                                                <span class="profile-incomplete-badge" title="Profile belum lengkap">
                                                    <i class="fas fa-exclamation-circle"></i> Tidak Lengkap
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $item->formatted_jenis_kelamin }}</td>
                                        <td>{{ $item->no_telepon ?? '-' }}</td>
                                        <td>
                                            <span title="{{ $item->alamat }}">
                                                {{ Str::limit($item->alamat, 40) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.data.warga-show', $item->id) }}"
                                                   class="btn btn-info btn-sm" style="border-radius: 8px;">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <form action="{{ route('admin.data.warga.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Yakin hapus warga {{ $item->nama_lengkap }}? Pastikan tidak ada pengajuan surat aktif!');"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 8px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-4 pb-4">
                            <div class="stats-info">
                                <i class="fas fa-info-circle"></i>
                                Menampilkan <strong>{{ $warga->count() }}</strong> dari <strong>{{ $totalWarga }}</strong> warga terdaftar
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <p>
                                @if(request('search'))
                                    Tidak ada hasil untuk pencarian "<strong>{{ request('search') }}</strong>"
                                @else
                                    Belum ada warga terdaftar.
                                @endif
                            </p>
                            @if(request('search'))
                                <a href="{{ route('admin.data.warga') }}" class="btn btn-reset">
                                    <i class="fas fa-undo"></i> Tampilkan Semua
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
