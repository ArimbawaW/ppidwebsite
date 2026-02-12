@extends('layouts.admin')

@section('title', 'Dashboard - PPID Admin')

@push('styles')
<style>
/* =========================================================
   GLOBAL OVERRIDE (FORCE THEME RESET)
   ========================================================= */
.card,
.card-header,
.card-body,
.table,
.table thead,
.table tbody,
.table tr,
.table td,
.table th {
    background-image: none !important;
    background-color: #fff !important;
    color: #212529 !important;
}

/* =========================================================
   STAT CARDS
   ========================================================= */
.stat-card {
    background: #ffffff !important;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 5px solid;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.12);
}

/* Permohonan */
.stat-card.blue-theme {
    border-left-color: #0d6efd;
    background: linear-gradient(135deg, #ffffff 0%, #f2f7ff 100%) !important;
}

/* Keberatan */
.stat-card.red-theme {
    border-left-color: #dc3545;
    background: linear-gradient(135deg, #ffffff 0%, #fff2f2 100%) !important;
}

.stat-label {
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.6px;
    color: #6c757d;
    text-transform: uppercase;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
}

.icon-box {
    padding: 16px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-box i {
    font-size: 40px;
}

/* =========================================================
   CARD HEADER (FORCE SAME HEADER)
   ========================================================= */
.card-header {
    background: #1A6B8A !important;
    color: #ffffff !important;
    border-bottom: none !important;
    border-radius: 12px 12px 0 0 !important;
}

.card-header h5,
.card-header i {
    color: #ffffff !important;
}

/* =========================================================
   TABLE FORCE STRUCTURE
   ========================================================= */
.table {
    width: 100% !important;
    table-layout: fixed !important;
    border-collapse: collapse !important;
}

.table thead th {
    font-weight: 700;
    font-size: 0.75rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #000 !important;
    background: #f8f9fa !important;
}

/* FORCE SAME COLUMN WIDTH */
.col-reg   { width: 35% !important; }
.col-name  { width: 22% !important; }
.col-stat  { width: 23% !important; text-align: center !important; }
.col-date  { width: 20% !important; text-align: center !important; }

/* =========================================================
   BADGE FORCE STYLE
   ========================================================= */
.badge {
    border-radius: 10px !important;
    font-weight: 700 !important;
    padding: 0.45em 0.9em !important;
    font-size: 0.7rem !important;
    letter-spacing: 0.4px;
}

.bg-warning {
    background: #ffc107 !important;
    color: #000 !important;
}

.bg-success {
    background: #198754 !important;
    color: #fff !important;
}

.bg-info {
    background: #0dcaf0 !important;
    color: #fff !important;
}

.bg-danger {
    background: #dc3545 !important;
    color: #fff !important;
}

.bg-secondary {
    background: #6c757d !important;
    color: #fff !important;
}

/* =========================================================
   BUTTON FORCE SAME STYLE
   ========================================================= */
.btn-outline-primary,
.btn-outline-danger {
    border-radius: 8px !important;
    font-weight: 600;
}

/* =========================================================
   ALIGNMENT FIX
   ========================================================= */
.table td, .table th {
    vertical-align: middle !important;
}

.text-nowrap {
    white-space: nowrap !important;
}

@media (max-width: 768px) {

    :root{
        --ppid-blue:#1A6B8A;
        --ppid-blue-dark:#13556e;
        --ppid-blue-soft:#e7f2f6;
    }

    /* PAGE HEADER */
    .page-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        border-left: 4px solid var(--ppid-blue);
        padding-left: 10px;
    }

    .page-header h2 {
        font-size: 1.2rem;
        color: var(--ppid-blue);
        font-weight: 700;
    }

    .page-header p {
        font-size: 0.8rem;
        color: var(--ppid-blue-dark);
    }

    /* STAT CARDS */
    .stat-card {
        padding: 1rem !important;
        border-left: 4px solid var(--ppid-blue);
    }

    .stat-number {
        font-size: 2rem !important;
        color: var(--ppid-blue);
        font-weight: 700;
    }

    .icon-box {
        padding: 10px !important;
        background: var(--ppid-blue-soft);
        border-radius: 8px;
    }

    .icon-box i {
        font-size: 26px !important;
        color: var(--ppid-blue);
    }

    /* TABLE CONTAINER */
    .card-body {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* TABLE STRUCTURE (KEEP PC MODEL) */
    .table {
        table-layout: fixed !important;
        width: 100% !important;
        min-width: 620px;
        font-size: 0.65rem !important;
    }

    /* HEADERS */
    .table thead th {
        font-size: 0.6rem !important;
        padding: 6px 6px !important;
        white-space: nowrap !important;
        background: var(--ppid-blue);
        color: #fff;
        border-bottom: 2px solid var(--ppid-blue-dark);
    }

    /* CELLS */
    .table td {
        padding: 6px 6px !important;
        font-size: 0.65rem !important;
        white-space: nowrap !important;
        color: var(--ppid-blue-dark);
    }

    /* FORCE COLUMN MODEL SAME AS PC */
    .col-reg   { width: 35% !important; }
    .col-name  { width: 22% !important; }
    .col-stat  { width: 23% !important; text-align: center !important; }
    .col-date  { width: 20% !important; text-align: center !important; }

    /* TEXT CUT CLEAN */
    .col-reg,
    .col-name {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* BADGES */
    .badge {
        font-size: 0.6rem !important;
        padding: 0.35em 0.6em !important;
        border-radius: 6px !important;
        white-space: nowrap;
        background: var(--ppid-blue);
        color: #fff;
    }

    /* BUTTONS */
    .btn {
        font-size: 0.7rem !important;
        padding: 6px 10px !important;
        background: var(--ppid-blue);
        border: none;
        color: #fff;
    }

    .btn:hover{
        background: var(--ppid-blue-dark);
        color:#fff;
    }

    /* CARD HEADER */
    .card-header {
        background: var(--ppid-blue);
        border-bottom: 2px solid var(--ppid-blue-dark);
    }

    .card-header h5 {
        font-size: 0.9rem !important;
        color: #fff;
        font-weight: 600;
    }

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
    <div>
        <span class="badge bg-light text-dark border">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </span>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="stat-card blue-theme">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label">Permohonan Perlu Verifikasi</p>
                    <h1 class="stat-number">{{ $stats['permohonan_pending'] ?? 0 }}</h1>
                </div>
                <div class="icon-box">
                    <i class="bi bi-envelope-exclamation text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="stat-card red-theme">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label">Keberatan Perlu Verifikasi</p>
                    <h1 class="stat-number">{{ $stats['keberatan_pending'] ?? 0 }}</h1>
                </div>
                <div class="icon-box">
                    <i class="bi bi-exclamation-octagon text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABLES --}}
<div class="row">

{{-- PERMOHONAN --}}
<div class="col-md-6 mb-4">
<div class="card shadow-sm border-0">
<div class="card-header">
<h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Permohonan Terbaru</h5>
</div>
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
<th class="col-reg">No. Registrasi</th>
<th class="col-name">Nama</th>
<th class="col-stat">Status</th>
<th class="col-date">Tanggal</th>
</tr>
</thead>
<tbody>
@forelse($permohonanTerbaru as $item)
<tr>
<td class="col-reg fw-bold">{{ $item->nomor_registrasi }}</td>
<td class="col-name">{{ Str::limit($item->nama, 12) }}</td>
<td class="col-stat">
@if($item->status === 'perlu_verifikasi')
<span class="badge bg-warning">Perlu Diverifikasi</span>
@elseif($item->status === 'diproses')
<span class="badge bg-info">Diproses</span>
@elseif(str_contains($item->status, 'dikabulkan'))
<span class="badge bg-success">Dikabulkan</span>
@elseif($item->status === 'ditolak')
<span class="badge bg-danger">Ditolak</span>
@else
<span class="badge bg-secondary">{{ $item->status }}</span>
@endif
</td>
<td class="col-date">{{ $item->created_at->format('d/m/y') }}</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-muted py-4">Belum ada permohonan</td></tr>
@endforelse
</tbody>
</table>

<div class="d-grid mt-3">
<a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
</div>

</div>
</div>
</div>

{{-- KEBERATAN --}}
<div class="col-md-6 mb-4">
<div class="card shadow-sm border-0">
<div class="card-header">
<h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Keberatan Terbaru</h5>
</div>
<div class="card-body">

<table class="table table-hover align-middle">
<thead>
<tr>
<th class="col-reg">No. Registrasi</th>
<th class="col-name">Nama</th>
<th class="col-stat">Status</th>
<th class="col-date">Tanggal</th>
</tr>
</thead>
<tbody>
@forelse($keberatanTerbaru as $item)
<tr>
<td class="col-reg fw-bold">{{ $item->nomor_registrasi }}</td>
<td class="col-name">{{ Str::limit($item->nama_pemohon ?? '-', 12) }}</td>
<td class="col-stat">
@if($item->status === 'pending')
<span class="badge bg-warning">Perlu Diverifikasi</span>
@elseif($item->status === 'diproses')
<span class="badge bg-info">Diproses</span>
@elseif($item->status === 'selesai')
<span class="badge bg-success">Selesai</span>
@else
<span class="badge bg-secondary">{{ $item->status }}</span>
@endif
</td>
<td class="col-date">{{ $item->created_at->format('d/m/y') }}</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada keberatan</td></tr>
@endforelse
</tbody>
</table>

<div class="d-grid mt-3">
<a href="{{ route('admin.keberatan.index') }}" class="btn btn-outline-danger btn-sm">Lihat Semua</a>
</div>

</div>
</div>
</div>

</div>

@endsection
