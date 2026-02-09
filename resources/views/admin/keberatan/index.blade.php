@extends('layouts.admin')

@section('title', 'Manajemen Keberatan')

@push('styles')
<style>
    /* === COMPACT TABLE MODE === */
    .table thead th {
        font-size: 0.6rem !important;
        padding: 0.4rem 0.5rem !important;
        letter-spacing: 0.04em;
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-weight: 700;
        color: #6c757d;
        border-top: none;
        line-height: 1.2;
    }

    .table tbody td {
        font-size: 0.7rem !important;
        padding: 0.3rem 0.5rem !important;
        line-height: 1.25;
        vertical-align: middle;
    }

    /* Reduce row height */
    .table tr {
        height: auto !important;
    }

    /* Compact badge */
    .status-badge {
        font-size: 0.58rem !important;
        padding: 0.3em 0.6em !important;
        min-width: 85px;
        max-width: 120px;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    /* Compact soft badge */
    .badge-soft-primary {
        font-size: 0.62rem;
        padding: 0.25em 0.45em;
        background-color: #eef2ff;
        color: #4338ca;
        border: 1px solid #e0e7ff;
        border-radius: 6px;
        display: inline-block;
    }

    /* Compact action button */
    .btn-action {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: 1px solid #e5e7eb;
        transition: all 0.2s;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    /* Compact text wrapping */
    .wrap-text {
        max-width: 180px;
        font-size: 0.7rem;
        line-height: 1.25;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Compact date cell */
    .date-cell {
        font-size: 0.68rem;
        line-height: 1.15;
    }

    .date-cell .small {
        font-size: 0.62rem;
    }

    /* Compact Indikator Waktu */
    .waktu-indikator {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 100px;
    }

    .waktu-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 0.3em 0.55em;
        font-size: 0.62rem;
        font-weight: 600;
        border-radius: 5px;
        white-space: nowrap;
    }

    .waktu-badge i {
        font-size: 0.75rem;
    }

    /* Warna Indikator */
    .waktu-badge.aman {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .waktu-badge.perhatian {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .waktu-badge.urgent {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .waktu-badge.terlambat {
        background-color: #7f1d1d;
        color: #ffffff;
        border: 1px solid #991b1b;
        animation: pulse-red 2s infinite;
    }

    .waktu-badge.selesai {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #d1fae5;
    }

    @keyframes pulse-red {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .sisa-hari-text {
        font-size: 0.6rem;
        color: #6b7280;
        text-align: center;
        line-height: 1.2;
    }

    /* Compact Progress Bar */
    .mini-progress {
        width: 100%;
        height: 3px;
        background-color: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
    }

    .mini-progress-bar {
        height: 100%;
        transition: width 0.3s ease;
    }

    .mini-progress-bar.aman { background-color: #10b981; }
    .mini-progress-bar.perhatian { background-color: #f59e0b; }
    .mini-progress-bar.urgent { background-color: #ef4444; }

    /* Compact Filter Stats */
    .filter-stats {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .stat-card {
        flex: 1;
        min-width: 140px;
        padding: 12px 15px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stat-card.aman {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .stat-card.perhatian {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .stat-card.urgent {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .stat-card h3 {
        font-size: 1.75rem;
        font-weight: bold;
        margin: 0;
    }

    .stat-card p {
        margin: 3px 0 0 0;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Fix DataTables select styling */
    div.dataTables_wrapper div.dataTables_length select {
        width: auto !important;
        height: 28px;
        font-size: 0.7rem;
        padding: 0.25rem 1.75rem 0.25rem 0.5rem;
        display: inline-block !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 12px 10px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        height: 28px;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    /* Fix font rendering */
    .dataTables_wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    .dataTables_info,
    .dataTables_paginate {
        font-size: 0.7rem;
    }

    .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }

    /* Reduce card padding */
    .card-body {
        padding: 0.5rem !important;
    }

    /* ===== FORCE STATUS COLOR SYSTEM ===== */
    .status-badge {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50rem !important;
        font-weight: 800 !important;
        border: none !important;
    }

    /* FORCE COLORS */
    .status-vibrant-warning { background: #FFB300 !important; color: #000 !important; }
    .status-vibrant-info { background: #00B0FF !important; color: #fff !important; }
    .status-vibrant-success { background: #00E676 !important; color: #000 !important; }
    .status-vibrant-danger { background: #FF1744 !important; color: #fff !important; }

    /* Bootstrap badge override */
    .badge.status-badge {
        background-image: none !important;
    }

    /* Compact link */
    .registrasi-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.72rem;
    }
    .registrasi-link:hover { text-decoration: underline; }

    /* Compact identitas */
    .identitas-cell .fw-bold {
        font-size: 0.72rem;
        margin-bottom: 2px;
    }

    .identitas-cell .small {
        font-size: 0.65rem;
    }
</style>
@endpush

@section('content')
<div class="page-header mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1" style="font-size: 1.5rem;">Daftar Keberatan</h3>
        <p class="text-muted mb-0" style="font-size: 0.8rem;">Manajemen dan penanganan keberatan pemohon informasi publik.</p>
    </div>

    <a href="{{ route('admin.rekap.keberatan.index') }}"
       class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-clipboard-data"></i>
        Rekap
    </a>
</div>

{{-- Statistik Indikator Waktu Keberatan --}}
@php
    $countAman = 0;
    $countPerhatian = 0;
    $countUrgent = 0;
    
    foreach($keberatan as $item) {
        $indikator = $item->indikator_waktu;
        $label = strtolower($indikator['label']);
        
        if ($label === 'aman') {
            $countAman++;
        } elseif ($label === 'perhatian') {
            $countPerhatian++;
        } elseif ($label === 'urgent' || $label === 'terlambat') {
            $countUrgent++;
        }
    }
@endphp

<div class="filter-stats">
    <div class="stat-card aman" onclick="filterByIndikator('aman')">
        <h3>{{ $countAman }}</h3>
        <p><i class="bi bi-check-circle"></i> Aman (H1-H14)</p>
    </div>
    <div class="stat-card perhatian" onclick="filterByIndikator('perhatian')">
        <h3>{{ $countPerhatian }}</h3>
        <p><i class="bi bi-exclamation-triangle"></i> Perhatian (H15-H21)</p>
    </div>
    <div class="stat-card urgent" onclick="filterByIndikator('urgent')">
        <h3>{{ $countUrgent }}</h3>
        <p><i class="bi bi-exclamation-circle"></i> Urgent (H22-H30)</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm d-flex align-items-center py-2" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <div style="font-size: 0.85rem;">{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="keberatanTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 35px;">No</th>
                        <th style="width: 140px;">No. Registrasi</th>
                        <th class="text-center" style="width: 110px;">Indikator Waktu</th>
                        <th style="width: 150px;">No. Permohonan</th>
                        <th style="width: 170px;">Identitas Pemohon</th>
                        <th style="width: 200px;">Alasan Keberatan</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th style="width: 90px;">Waktu Masuk</th>
                        <th class="text-center" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
@forelse($keberatan as $index => $item)
    @php
        // Ambil indikator waktu
        $indikator = $item->indikator_waktu;
        
        // Tentukan status class dan label
        $statusMapping = [
            'pending' => ['class' => 'status-vibrant-warning', 'label' => 'Perlu Verifikasi'],
            'perlu_verifikasi' => ['class' => 'status-vibrant-warning', 'label' => 'Perlu Verifikasi'],
            'diproses' => ['class' => 'status-vibrant-info', 'label' => 'Sedang Diproses'],
            'ditunda' => ['class' => 'status-vibrant-danger', 'label' => 'Ditunda'],
            'selesai' => ['class' => 'status-vibrant-success', 'label' => 'Selesai'],
            'dikabulkan' => ['class' => 'status-vibrant-success', 'label' => 'Dikabulkan'],
            'ditolak' => ['class' => 'status-vibrant-danger', 'label' => 'Ditolak'],
        ];
        
        $statusClass = $statusMapping[$item->status]['class'] ?? 'status-vibrant-warning';
        $statusLabel = $statusMapping[$item->status]['label'] ?? 'Unknown';
        
        // Tentukan icon berdasarkan status
        $statusIcons = [
            'pending' => 'exclamation-circle-fill',
            'perlu_verifikasi' => 'exclamation-circle-fill',
            'diproses' => 'arrow-repeat',
            'ditunda' => 'pause-circle-fill',
            'selesai' => 'check-circle-fill',
            'dikabulkan' => 'check-circle-fill',
            'ditolak' => 'x-octagon-fill',
        ];
        
        $statusIcon = $statusIcons[$item->status] ?? 'question-circle-fill';
    @endphp
    
    <tr data-indikator="{{ strtolower($indikator['label']) }}">
        <td class="text-center text-muted">{{ $index + 1 }}</td>
        <td>
            <a href="{{ route('admin.keberatan.show', $item) }}" class="registrasi-link">
                {{ $item->nomor_registrasi }}
            </a>
        </td>

        <td>
            <div class="waktu-indikator">
                <span class="waktu-badge {{ strtolower($indikator['label']) }}">
                    <i class="bi bi-{{ $indikator['icon'] }}"></i>
                    {{ $indikator['label'] }}
                </span>

                @if($item->tanggal_selesai)
                    <span class="sisa-hari-text">
                        ✓ {{ $indikator['hari_terpakai'] }} hari
                    </span>
                @elseif(isset($indikator['terlambat']) && $indikator['terlambat'])
                    <span class="sisa-hari-text text-danger fw-bold">
                        +{{ $indikator['hari_keterlambatan'] }} hari
                    </span>
                @else
                    <span class="sisa-hari-text">
                        Sisa: {{ $indikator['sisa_hari'] }} hari
                    </span>
                    <div class="mini-progress">
                        <div class="mini-progress-bar {{ strtolower($indikator['label']) }}" 
                             style="width: {{ $indikator['persentase'] }}%"></div>
                    </div>
                @endif
            </div>
        </td>

        <td>
            <span class="badge-soft-primary small">
                {{ $item->permohonan ? $item->permohonan->nomor_registrasi : '-' }}
            </span>
        </td>

        <td>
            <div class="identitas-cell">
                <div class="fw-bold text-dark">{{ $item->nama_pemohon }}</div>
                <div class="small text-muted text-truncate" style="max-width: 160px;">
                    <i class="bi bi-envelope me-1"></i>{{ $item->email }}
                </div>
            </div>
        </td>

        <td>
            <div class="wrap-text" title="{{ $item->alasan_keberatan_label }}">
                {{ $item->alasan_keberatan_label }}
            </div>
        </td>

        <td class="text-center">
            <span class="badge status-badge {{ $statusClass }}">
                <i class="bi bi-{{ $statusIcon }} me-1"></i>
                {{ $statusLabel }}
            </span>
        </td>

        <td>
            <div class="date-cell">
                <div class="fw-bold">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</div>
                <div class="text-muted small">{{ $item->created_at?->format('H:i') ?? '' }}</div>
            </div>
        </td>

        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <a href="{{ route('admin.keberatan.show', $item) }}" class="btn btn-sm btn-info btn-action">
                    <i class="bi bi-eye"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger btn-action" onclick="confirmDelete({{ $item->id }})">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.keberatan.destroy', $item) }}" method="POST" class="d-none">
                @csrf @method('DELETE')
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center text-muted py-4">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            <p class="mb-0">Belum ada data keberatan</p>
        </td>
    </tr>
@endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#keberatanTable').DataTable({
        pageLength: 25,
        responsive: false,
        order: [[0, 'asc']], 
        language: {
            processing: "Memproses...",
            search: "",
            searchPlaceholder: "Cari...",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 - 0 dari 0 entri",
            infoFiltered: "(dari _MAX_ total)",
            loadingRecords: "Memuat data...",
            zeroRecords: "Tidak ada data",
            emptyTable: "Tidak ada data keberatan",
            paginate: {
                first: "‹‹",
                previous: "‹",
                next: "›",
                last: "››"
            }
        },
        dom: "<'row px-2 py-2'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row px-2 py-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    $('.dataTables_filter input').addClass('form-control-sm');
    $('.dataTables_length select').addClass('form-select-sm');
});

function filterByIndikator(tipe) {
    const table = $('#keberatanTable').DataTable();
    
    if (tipe === 'aman') {
        table.column(2).search('^aman$', true, false).draw();
    } else if (tipe === 'perhatian') {
        table.column(2).search('perhatian', true, false).draw();
    } else if (tipe === 'urgent') {
        table.column(2).search('urgent|terlambat', true, false).draw();
    }
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data keberatan ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush