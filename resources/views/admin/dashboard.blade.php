@extends('layouts.admin')

@section('title', 'Dashboard - PPID Admin')

@push('styles')
<style>
    .stat-card {
        background: #fff;
        padding: 1.5rem;
        border-radius: 10px;
        border-left: 5px solid;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    /* Tema Biru untuk Permohonan */
    .stat-card.blue-theme {
        border-left-color: #0d6efd;
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
    }
    
    .stat-card.blue-theme .stat-number {
        color: #0d6efd;
    }
    
    .stat-card.blue-theme .icon-box {
        background: rgba(13, 110, 253, 0.1);
    }
    
    .stat-card.blue-theme .icon-box i {
        color: #0d6efd;
    }
    
    /* Tema Merah Soft untuk Keberatan */
    .stat-card.red-theme {
        border-left-color: #dc3545;
        background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%);
    }
    
    .stat-card.red-theme .stat-number {
        color: #dc3545;
    }
    
    .stat-card.red-theme .icon-box {
        background: rgba(220, 53, 69, 0.08);
    }
    
    .stat-card.red-theme .icon-box i {
        color: #dc3545;
    }
    
    .stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        margin: 0;
    }
    
    .icon-box {
        padding: 16px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-box i {
        font-size: 40px;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Dashboard</h2>
        <p class="text-muted">Selamat datang di Panel Admin PPID Kementerian PKP</p>
    </div>
    <div class="text-end">
        <span class="badge bg-light text-dark border">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </span>
    </div>
</div>

{{-- STATISTICS CARDS - 2 KOTAK DENGAN TEMA WARNA --}}
<div class="row mb-4">
    {{-- Permohonan Perlu Verifikasi - TEMA BIRU --}}
    <div class="col-md-6 mb-3">
        <div class="stat-card blue-theme">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">Permohonan Perlu Verifikasi</p>
                    <h1 class="stat-number">{{ $stats['permohonan_pending'] ?? 0 }}</h1>
                </div>
                <div class="icon-box">
                    <i class="bi bi-envelope-exclamation"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Keberatan Perlu Verifikasi - TEMA MERAH SOFT --}}
    <div class="col-md-6 mb-3">
        <div class="stat-card red-theme">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label">Keberatan Perlu Verifikasi</p>
                    <h1 class="stat-number">{{ $stats['keberatan_pending'] ?? 0 }}</h1>
                </div>
                <div class="icon-box">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RECENT DATA --}}
<div class="row">
    {{-- Permohonan Terbaru --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Permohonan Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap" width="35%">No. Registrasi</th>
                                <th class="text-nowrap" width="22%">Nama</th>
                                <th class="text-nowrap" width="23%">Status</th>
                                <th class="text-nowrap" width="20%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permohonanTerbaru as $item)
                            <tr>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.permohonan.show', $item) }}" class="fw-bold text-decoration-none small">
                                        {{ $item->nomor_registrasi }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($item->nama, 12) }}</td>
                                <td>
                                    @if($item->status === 'perlu_verifikasi')
                                        <span class="badge bg-warning text-dark">Verifikasi</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="badge bg-info text-white">Diproses</span>
                                    @elseif(str_contains($item->status, 'dikabulkan'))
                                        <span class="badge bg-success">Dikabulkan</span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="text-nowrap"><small class="text-muted">{{ $item->created_at->format('d/m/y') }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada permohonan masuk</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-grid mt-3">
                    <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Keberatan Terbaru --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Keberatan Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 180px;">No. Registrasi</th>
                                <th style="min-width: 100px;">Nama</th>
                                <th style="min-width: 100px;">Status</th>
                                <th style="min-width: 90px;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keberatanTerbaru as $item)
                            <tr>
                                <td><span class="fw-bold">{{ $item->nomor_registrasi }}</span></td>
                                <td>{{ Str::limit($item->nama_pemohon ?? '-', 15) }}</td>
                                <td>
                                    @if($item->status === 'pending')
                                        <span class="badge bg-warning text-dark">Perlu Verifikasi</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="badge bg-info text-white">Diproses</span>
                                    @elseif($item->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td><small class="text-muted text-nowrap">{{ $item->created_at->format('d/m/y') }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Tidak ada keberatan baru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-grid mt-3">
                    <a href="{{ route('admin.keberatan.index') }}" class="btn btn-outline-danger btn-sm">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection