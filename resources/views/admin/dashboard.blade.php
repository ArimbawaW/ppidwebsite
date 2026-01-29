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

{{-- STATISTICS CARDS --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #ffc107;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 text-muted small fw-bold">PERLU VERIFIKASI</p>
                    <h3 class="fw-bold" style="color: #ffc107;">{{ $stats['permohonan_pending'] ?? 0 }}</h3>
                </div>
                <div style="background: rgba(255, 193, 7, 0.1); padding: 12px; border-radius: 10px;">
                    <i class="bi bi-envelope-exclamation" style="font-size: 24px; color: #ffc107;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #0dcaf0;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 text-muted small fw-bold">KEBERATAN PENDING</p>
                    <h3 class="fw-bold" style="color: #0dcaf0;">{{ $stats['keberatan_pending'] ?? 0 }}</h3>
                </div>
                <div style="background: rgba(13, 202, 240, 0.1); padding: 12px; border-radius: 10px;">
                    <i class="bi bi-exclamation-octagon" style="font-size: 24px; color: #0dcaf0;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #198754;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 text-muted small fw-bold">TOTAL BERITA</p>
                    <h3 class="fw-bold" style="color: #198754;">{{ $stats['berita_total'] ?? 0 }}</h3>
                </div>
                <div style="background: rgba(25, 135, 84, 0.1); padding: 12px; border-radius: 10px;">
                    <i class="bi bi-newspaper" style="font-size: 24px; color: #198754;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #6f42c1;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 text-muted small fw-bold">TOTAL PERMOHONAN</p>
                    <h3 class="fw-bold" style="color: #6f42c1;">{{ $stats['total_permohonan'] ?? 0 }}</h3>
                </div>
                <div style="background: rgba(111, 66, 193, 0.1); padding: 12px; border-radius: 10px;">
                    <i class="bi bi-files" style="font-size: 24px; color: #6f42c1;"></i>
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
            <div class="card-header bg-white py-3">
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
            <div class="card-header bg-white py-3">
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
                                        <span class="badge bg-warning text-dark">Pending</span>
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
                    <a href="{{ route('admin.keberatan.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.berita.create') }}" class="btn btn-light border w-100 py-3 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-newspaper fs-3 mb-2 text-primary"></i>
                    <span class="small fw-bold">Tambah Berita</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.informasi-publik.create') }}" class="btn btn-light border w-100 py-3 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-file-earmark-text fs-3 mb-2 text-success"></i>
                    <span class="small fw-bold">Tambah Info</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.galeri.create') }}" class="btn btn-light border w-100 py-3 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-images fs-3 mb-2 text-info"></i>
                    <span class="small fw-bold">Upload Galeri</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.agenda-kegiatan.create') }}" class="btn btn-light border w-100 py-3 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-calendar-event fs-3 mb-2 text-warning"></i>
                    <span class="small fw-bold">Tambah Agenda</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection