@extends('layouts.admin')

@section('title', 'Dashboard - PPID Admin')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h2>Dashboard</h2>
        <p>Selamat datang di Panel Admin PPID Kementerian PKP</p>
    </div>
    <div>
        <span class="text-muted">
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
                    <p class="mb-1" style="font-size: 14px; color: #6c757d; font-weight: 600;">Permohonan Pending</p>
                    <h3 style="color: #ffc107;">{{ $stats['permohonan_pending'] }}</h3>
                </div>
                <div style="background: rgba(255, 193, 7, 0.1); padding: 15px; border-radius: 10px;">
                    <i class="bi bi-envelope" style="font-size: 24px; color: #ffc107;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #0dcaf0;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1" style="font-size: 14px; color: #6c757d; font-weight: 600;">Keberatan Pending</p>
                    <h3 style="color: #0dcaf0;">{{ $stats['keberatan_pending'] }}</h3>
                </div>
                <div style="background: rgba(13, 202, 240, 0.1); padding: 15px; border-radius: 10px;">
                    <i class="bi bi-exclamation-circle" style="font-size: 24px; color: #0dcaf0;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #198754;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1" style="font-size: 14px; color: #6c757d; font-weight: 600;">Total Berita</p>
                    <h3 style="color: #198754;">{{ $stats['berita_total'] }}</h3>
                </div>
                <div style="background: rgba(25, 135, 84, 0.1); padding: 15px; border-radius: 10px;">
                    <i class="bi bi-newspaper" style="font-size: 24px; color: #198754;"></i>
                </div>
            </div>
        </div>
    </div>

    
</div>

{{-- RECENT DATA --}}
<div class="row">
    
    {{-- Permohonan Terbaru --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-envelope me-2"></i>
                    Permohonan Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No. Registrasi</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permohonanTerbaru as $item)
                            <tr>
                                <td><strong>{{ $item->nomor_registrasi }}</strong></td>
                                <td>{{ Str::limit($item->nama ?? '-', 20) }}</td>
                                <td>
                                    @if($item->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($item->status === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3"></i>
                                    <p class="mb-0 mt-2">Tidak ada data</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.permohonan.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Keberatan Terbaru --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Keberatan Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No. Registrasi</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keberatanTerbaru as $item)
                            <tr>
                                <td><strong>{{ $item->nomor_registrasi }}</strong></td>
                                <td>{{ Str::limit($item->nama_pemohon ?? '-', 20) }}</td>
                                <td>
                                    @if($item->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($item->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3"></i>
                                    <p class="mb-0 mt-2">Tidak ada data</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.keberatan.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- QUICK ACTIONS --}}
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-lightning me-2"></i>
            Quick Actions
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.berita.create') }}" class="btn btn-outline-primary w-100 py-3">
                    <i class="bi bi-plus-circle fs-4 d-block mb-2"></i>
                    <span class="fw-semibold">Tambah Berita</span>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.informasi-publik.create') }}" class="btn btn-outline-success w-100 py-3">
                    <i class="bi bi-file-earmark-plus fs-4 d-block mb-2"></i>
                    <span class="fw-semibold">Tambah Informasi</span>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.galeri.create') }}" class="btn btn-outline-info w-100 py-3">
                    <i class="bi bi-image fs-4 d-block mb-2"></i>
                    <span class="fw-semibold">Upload Galeri</span>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.agenda-kegiatan.create') }}" class="btn btn-outline-warning w-100 py-3">
                    <i class="bi bi-calendar-plus fs-4 d-block mb-2"></i>
                    <span class="fw-semibold">Tambah Agenda</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection