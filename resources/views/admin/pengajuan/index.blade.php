{{-- resources/views/admin/pengajuan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengajuan Surat')
@section('page_title', 'Kelola Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengajuan Surat</li>
@endsection

@section('active-pengajuan', 'active')

@push('styles')
<style>
    /* Modern Card */
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modern-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    .modern-card .card-header .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modern-card .card-header .card-tools {
        margin-left: auto;
    }

    .filter-select {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 200px;
    }

    .filter-select:focus {
        background: white;
        color: #667eea;
        outline: none;
    }

    .filter-select option {
        color: #2d3748;
        background: white;
    }

    .modern-table thead th {
        background: #f7fafc;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 12px 15px;
        border: none;
        white-space: nowrap;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-table tbody tr:hover {
        background: #f7fafc;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        color: #2d3748;
        border: none;
        font-size: 0.9rem;
    }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-menunggu { background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%); color: #2d3436; }
    .badge-perbaikan { background: linear-gradient(135deg, #ff7675 0%, #d63031 100%); color: white; }
    .badge-proses, .badge-sedang_diproses { background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); color: white; }
    .badge-selesai { background: linear-gradient(135deg, #55efc4 0%, #00b894 100%); color: white; }

    .btn-detail-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-detail-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .empty-icon i {
        font-size: 3.5rem;
        color: #cbd5e0;
    }

    .info-text {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        padding: 15px 20px;
        border-radius: 10px;
        border-left: 4px solid #667eea;
        margin-top: 20px;
    }

    @media (max-width: 992px) {
        .modern-card .card-header { padding: 18px 20px; }
        .modern-card .card-header h3 { font-size: 1.1rem; }
        .filter-select { min-width: 180px; font-size: 0.85rem; }
        .modern-table thead th { padding: 10px 12px; font-size: 0.75rem; }
        .modern-table tbody td { padding: 10px 12px; font-size: 0.85rem; }
    }

    @media (max-width: 768px) {
        .modern-card .card-header { padding: 15px 18px; }
        .modern-card .card-header .card-title { font-size: 1.05rem; margin-bottom: 12px; }
        .modern-card .card-header .card-tools { width: 100%; margin-left: 0; text-align: center; }
        .filter-select { width: 100%; font-size: 0.85rem; padding: 8px 12px; text-align: center; }
        .modern-table thead th { padding: 10px 12px; font-size: 0.75rem; }
        .modern-table tbody td { padding: 10px 12px; font-size: 0.85rem; }
        .modern-table thead th:nth-child(4), .modern-table tbody td:nth-child(4),
        .modern-table thead th:nth-child(5), .modern-table tbody td:nth-child(5) { display: none; }
        .number-badge { width: 26px; height: 26px; font-size: 0.8rem; }
    }

    @media (max-width: 576px) {
        .modern-card .card-header { padding: 15px; }
        .modern-card .card-header .card-title { font-size: 0.95rem; text-align: center; width: 100%; }
        .modern-card .card-header .card-title i { display: none; }
        .modern-card .card-header .card-tools { text-align: center; }
        .filter-select { padding: 8px 12px; font-size: 0.8rem; text-align: center; }
        .modern-table thead th { padding: 8px 10px; font-size: 0.7rem; }
        .modern-table thead th i { display: none; }
        .modern-table tbody td { padding: 8px 10px; font-size: 0.8rem; }
        .modern-table tbody td:nth-child(1) { padding: 8px 5px; }
        .modern-table tbody td:nth-child(2) small:last-child { display: none; }
        .number-badge { width: 24px; height: 24px; font-size: 0.75rem; }
        .badge-modern { padding: 4px 8px; font-size: 0.7rem; }
        .badge-modern i { display: none; }
        .btn-detail-modern { padding: 5px 10px; font-size: 0.75rem; }
        .btn-detail-modern i { display: none; }
        .info-text { padding: 12px 15px; font-size: 0.85rem; }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    <span>Daftar Pengajuan Surat</span>
                </h3>
                <div class="card-tools">
                    <select class="filter-select" onchange="window.location.href='?status='+this.value">
                        <option value="">📋 Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                        <option value="perbaikan_surat" {{ request('status') == 'perbaikan_surat' ? 'selected' : '' }}>⚠️ Perlu Perbaikan</option>
                        <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>🔄 Sedang Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> #</th>
                                    <th><i class="fas fa-user"></i> Warga</th>
                                    <th><i class="fas fa-file-alt"></i> Jenis Surat</th>
                                    <th><i class="fas fa-info-circle"></i> Keperluan</th>
                                    <th><i class="far fa-calendar"></i> Tanggal</th>
                                    <th><i class="fas fa-signal"></i> Status</th>
                                    <th><i class="fas fa-cog"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan as $item)
                                <tr>
                                    <td>
                                        <span class="number-badge">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $item->user->nama_lengkap }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $item->user->nik }}</small>
                                        <br>
                                        <small class="text-muted">{{ $item->user->no_telepon ?? '-' }}</small>
                                    </td>
                                    <td><strong>{{ $item->suratJenis->nama }}</strong></td>
                                    <td>
                                        <span title="{{ $item->keperluan }}">
                                            {{ Str::limit($item->keperluan, 50) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                        <small style="color: #9ca3af;">{{ $item->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="badge-modern {{ $item->status_badge_class }}">
                                            <i class="fas fa-circle" style="font-size: 6px;"></i>
                                            {{ $item->status_label }}
                                        </span>
                                        @if($item->keterangan_admin)
                                            <br>
                                            <small class="text-muted" title="{{ $item->keterangan_admin }}">
                                                {{ Str::limit($item->keterangan_admin, 30) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.pengajuan.show', $item->id) }}"
                                               class="btn-detail-modern btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <form action="{{ route('admin.pengajuan.destroy', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin hapus pengajuan #{{ $item->id }} dari {{ $item->user->nama_lengkap }}? Semua dokumen akan dihapus!');"
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 8px; padding: 6px 12px;">
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

                    <div class="info-text">
                        <p>
                            <i class="fas fa-info-circle me-2"></i>
                            Menampilkan <strong>{{ $pengajuan->count() }}</strong> dari <strong>{{ $totalPengajuan }}</strong> pengajuan surat
                        </p>
                    </div>
                @else
                    <div class="empty-state-modern">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h5>Belum Ada Pengajuan Surat</h5>
                        <p>Belum ada pengajuan surat yang masuk saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
