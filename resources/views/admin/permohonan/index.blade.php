@extends('layouts.admin')

@section('title', 'Daftar Permohonan')

@push('styles')
<style>
    /* ========================================
       COMPACT TABLE STYLING
       ======================================== */
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05);
        border-radius: 0.85rem;
    }

    /* Compact table headers */
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.6rem !important;
        font-weight: 700;
        letter-spacing: 0.04em;
        color: #6c757d;
        border-top: none;
        padding: 0.4rem 0.5rem !important;
        line-height: 1.2;
    }

    /* Compact table body */
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

    /* Compact Status Badge */
    .status-badge {
        font-size: 0.58rem !important;
        padding: 0.3em 0.6em !important;
        border-radius: 50rem !important;
        letter-spacing: 0.02em;
        min-width: 85px;
        max-width: 120px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Compact Detail Tags */
    .detail-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 3px;
        max-width: 280px;
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        padding: 0.25em 0.5em !important;
        font-size: 0.62rem !important;
        font-weight: 500 !important;
        border-radius: 4px !important;
        line-height: 1.1;
        border: 1px solid transparent;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .badge-soft i {
        margin-right: 3px;
        font-size: 0.7rem;
    }

    /* Premium Pastel Colors */
    .badge-soft-primary { background-color: #eef2ff; color: #4338ca; border-color: #e0e7ff; }
    .badge-soft-success { background-color: #ecfdf5; color: #065f46; border-color: #d1fae5; }
    .badge-soft-info    { background-color: #f0f9ff; color: #0369a1; border-color: #e0f2fe; }
    .badge-soft-warning { background-color: #fffbeb; color: #92400e; border-color: #fef3c7; }
    .badge-soft-secondary { background-color: #f9fafb; color: #374151; border-color: #f3f4f6; }

    /* Compact Action Buttons - SAMA SEPERTI KEBERATAN */
    .btn-action {
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 0;
        border: 1px solid transparent;
        transition: all 0.2s;
        font-size: 0.7rem;
    }

    .btn-action.btn-info {
        background-color: #17a2b8;
        color: #fff;
        border-color: #17a2b8;
    }

    .btn-action.btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3);
    }

    .btn-action.btn-danger {
        background-color: #dc3545;
        color: #fff;
        border-color: #dc3545;
    }

    .btn-action.btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }

    /* Compact Link Style */
    .registrasi-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.72rem;
    }
    .registrasi-link:hover { text-decoration: underline; }
    
    /* Table responsive */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
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
    
        color: #065f46;
       
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

    /* Compact DataTables Controls */
    div.dataTables_wrapper div.dataTables_length select {
        width: auto !important;
        display: inline-block !important;
        padding: 0.25rem 1.75rem 0.25rem 0.5rem !important;
        font-size: 0.7rem !important;
        height: 28px !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 12px 10px;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        height: 28px !important;
        font-size: 0.7rem !important;
        padding: 0.25rem 0.5rem !important;
    }

    .dataTables_info,
    .dataTables_paginate {
        font-size: 0.7rem !important;
    }

    .page-link {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.7rem !important;
    }

    /* Fix font rendering */
    .dataTables_wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    /* Compact card body */
    .card-body {
        padding: 0.5rem !important;
    }

    /* Compact page header */
    .page-header h3 {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .page-header p {
        font-size: 0.8rem;
    }

    /* Compact identitas cell */
    .identitas-cell .fw-bold {
        font-size: 0.72rem;
        margin-bottom: 2px;
    }

    .identitas-cell .small {
        font-size: 0.65rem;
    }

    /* Compact date cell */
    .date-cell .fw-bold {
        font-size: 0.68rem;
    }

    .date-cell .small {
        font-size: 0.62rem;
    }
</style>
@endpush

@section('content')
<div class="page-header mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1">Daftar Permohonan</h3>
        <p class="text-muted mb-0">Manajemen dan verifikasi permohonan informasi publik.</p>
    </div>

    <a href="{{ route('admin.rekap.permohonan.index') }}"
       class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-bar-chart-line"></i>
        Rekap
    </a>
</div>

{{-- Statistik Indikator Waktu - HITUNG DARI PHP (SELESAI TIDAK MASUK AMAN) --}}
@php
    $countAman = 0;
    $countPerhatian = 0;
    $countUrgent = 0;
    
    foreach($permohonan as $item) {
        $indikator = $item->indikator_waktu;
        $label = strtolower($indikator['label']);
        
        // PENTING: Selesai TIDAK dihitung sebagai Aman
        if ($label === 'aman') {
            $countAman++;
        } elseif ($label === 'perhatian') {
            $countPerhatian++;
        } elseif ($label === 'urgent' || $label === 'terlambat') {
            $countUrgent++;
        }
        // 'selesai' tidak masuk ke perhitungan manapun
    }
@endphp

<div class="filter-stats">
    <div class="stat-card aman" onclick="filterByIndikator('aman')">
        <h3>{{ $countAman }}</h3>
        <p><i class="bi bi-check-circle"></i> Aman (H1-H5)</p>
    </div>
    <div class="stat-card perhatian" onclick="filterByIndikator('perhatian')">
        <h3>{{ $countPerhatian }}</h3>
        <p><i class="bi bi-exclamation-triangle"></i> Perhatian (H6-H8)</p>
    </div>
    <div class="stat-card urgent" onclick="filterByIndikator('urgent')">
        <h3>{{ $countUrgent }}</h3>
        <p><i class="bi bi-exclamation-circle"></i> Urgent (H9-H10)</p>
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
            <table class="table table-hover align-middle mb-0" id="permohonanTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 35px;">No</th>
                        <th style="width: 150px;">No. Registrasi</th>
                        <th class="text-center" style="width: 110px;">Indikator Waktu</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                        <th style="width: 180px;">Identitas Pemohon</th>
                        <th style="width: 250px;">Detail Kategorisasi</th>
                        <th style="width: 90px;">Waktu Masuk</th>
                        <th class="text-center" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($permohonan as $index => $item)
                    @php
                        $indikator = $item->indikator_waktu;
                        $statusMap = [
                            'perlu_verifikasi'      => 'bg-warning text-dark',
                            'diproses'              => 'bg-info text-white',
                            'ditunda'               => 'bg-secondary text-white',
                            'dikabulkan_seluruhnya' => 'bg-success text-white',
                            'dikabulkan_sebagian'   => 'bg-success text-white',
                            'ditolak'               => 'bg-danger text-white'
                        ];
                        $class = $statusMap[$item->status] ?? 'bg-secondary text-white';
                    @endphp
                    <tr data-indikator="{{ strtolower($indikator['label']) }}">
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td>
                            <a href="{{ route('admin.permohonan.show', $item) }}" class="registrasi-link">
                                {{ $item->nomor_registrasi }}
                            </a>
                        </td>
                        
                        {{-- KOLOM INDIKATOR WAKTU --}}
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
                                        +{{ $indikator['hari_keterlambatan'] }}hari
                                    </span>
                                @else
                                    <span class="sisa-hari-text">
                                        Sisa: {{ $indikator['sisa_hari'] }}hari
                                    </span>
                                    <div class="mini-progress">
                                        <div class="mini-progress-bar {{ strtolower($indikator['label']) }}" 
                                             style="width: {{ $indikator['persentase'] }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="badge status-badge {{ $class }}">
                                {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                        
                        <td>
                            <div class="identitas-cell">
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 170px;">
                                    <i class="bi bi-envelope me-1"></i>{{ $item->email }}
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="detail-tags">
                                @if($item->kategori_informasi_label)
                                    <span class="badge badge-soft badge-soft-info" title="Kategori">
                                        <i class="bi bi-tag"></i> {{ $item->kategori_informasi_label }}
                                    </span>
                                @endif
                                
                                @if($item->jenis_permohonan_informasi_label)
                                    <span class="badge badge-soft badge-soft-primary" title="Jenis Permohonan">
                                        <i class="bi bi-file-earmark-text"></i> {{ Str::limit($item->jenis_permohonan_informasi_label, 20) }}
                                    </span>
                                @endif
                                
                                @if($item->status_informasi_label)
                                    <span class="badge badge-soft badge-soft-success" title="Status Informasi">
                                        <i class="bi bi-info-circle"></i> {{ $item->status_informasi_label }}
                                    </span>
                                @endif

                                @if($item->bentuk_informasi_label)
                                    <span class="badge badge-soft badge-soft-warning" title="Bentuk Informasi">
                                        <i class="bi bi-layers"></i> {{ $item->bentuk_informasi_label }}
                                    </span>
                                @endif

                                @if($item->jenis_permintaan_label)
                                    <span class="badge badge-soft badge-soft-secondary" title="Jenis Permintaan">
                                        <i class="bi bi-hand-index"></i> {{ Str::limit($item->jenis_permintaan_label, 15) }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="date-cell">
                                <div class="fw-bold">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</div>
                                <div class="text-muted small">{{ $item->created_at?->format('H:i') ?? '' }}</div>
                            </div>
                        </td>
                        
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.permohonan.show', $item) }}" class="btn btn-sm btn-info btn-action" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger btn-action" onclick="confirmDelete({{ $item->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.permohonan.destroy', $item) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const table = $('#permohonanTable').DataTable({
        pageLength: 25,
        responsive: true,
        order: [[0, 'asc']], 
        language: {
            search: "",
            searchPlaceholder: "Cari...",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 - 0 dari 0 entri",
            infoFiltered: "(dari _MAX_ total)",
            zeroRecords: "Tidak ada data",
            emptyTable: "Tidak ada data tersedia",
            paginate: { 
                first: "‹‹",
                last: "››",
                previous: "‹", 
                next: "›" 
            }
        },
        dom: "<'row px-2 py-2'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row px-2 py-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    $('.dataTables_filter input').addClass('form-control form-control-sm border-secondary-subtle');
    $('.dataTables_length select').addClass('form-select form-select-sm border-secondary-subtle');
});

function filterByIndikator(tipe) {
    const table = $('#permohonanTable').DataTable();
    
    // PENTING: Filter hanya untuk yang belum selesai
    if (tipe === 'aman') {
        table.column(2).search('^aman$', true, false).draw(); // Hanya "aman", tidak termasuk "selesai"
    } else if (tipe === 'perhatian') {
        table.column(2).search('perhatian', true, false).draw();
    } else if (tipe === 'urgent') {
        table.column(2).search('urgent|terlambat', true, false).draw();
    }
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data permohonan ini secara permanen?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush