@extends('layouts.admin')

@section('title', 'Daftar Permohonan')

@push('styles')
<style>
    /* Card & Container Styling */
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05);
        border-radius: 0.85rem;
    }

    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #6c757d;
        border-top: none;
        padding: 1rem 0.75rem;
    }

    /* Status Badge (Solid) */
    .status-badge {
        font-size: 0.65rem !important;
        padding: 0.5em 0.8em !important;
        border-radius: 50rem !important; /* Pill style */
        letter-spacing: 0.03em;
        min-width: 90px;
        display: inline-block;
    }

    /* Detail Tags Styling (Soft UI) */
    .detail-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        max-width: 350px;
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        padding: 0.4em 0.7em !important;
        font-size: 0.72rem !important;
        font-weight: 500 !important;
        border-radius: 6px !important;
        line-height: 1.2;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .badge-soft i {
        margin-right: 5px;
        font-size: 0.8rem;
    }

    /* Premium Pastel Colors */
    .badge-soft-primary { background-color: #eef2ff; color: #4338ca; border-color: #e0e7ff; }
    .badge-soft-success { background-color: #ecfdf5; color: #065f46; border-color: #d1fae5; }
    .badge-soft-info    { background-color: #f0f9ff; color: #0369a1; border-color: #e0f2fe; }
    .badge-soft-warning { background-color: #fffbeb; color: #92400e; border-color: #fef3c7; }
    .badge-soft-secondary { background-color: #f9fafb; color: #374151; border-color: #f3f4f6; }

    /* Action Buttons */
    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        padding: 0;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #4b5563;
        transition: all 0.2s;
    }

    .btn-action:hover {
        background: #f3f4f6;
        color: #111827;
        border-color: #d1d5db;
        transform: translateY(-1px);
    }

    .btn-action.delete:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* Link Style */
    .registrasi-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }
    .registrasi-link:hover { text-decoration: underline; }
    /* Pastikan tabel mengambil lebar penuh dan tidak terpotong */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Membatasi lebar kolom Detail agar tidak mendorong kolom Aksi ke luar */
.detail-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    width: 100%;
    min-width: 200px; /* Lebar minimum */
    max-width: 280px; /* Batasi maksimal agar tidak lebar ke samping */
}

/* Memperkecil padding badge sedikit agar lebih hemat ruang */
.badge-soft {
    padding: 0.3em 0.6em !important;
    white-space: normal; /* Biarkan teks membungkus ke bawah jika terlalu panjang */
    text-align: left;
}

/* Kunci lebar kolom Aksi agar tidak mengecil atau terpotong */
th:last-child, td:last-child {
    min-width: 100px;
    position: sticky;
    right: 0;
    background-color: inherit; /* Menjaga icon tetap terlihat saat scroll di mobile */
    z-index: 1;
}

    
</style>
@endpush

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1">Daftar Permohonan</h3>
        <p class="text-muted mb-0">
            Manajemen dan verifikasi permohonan informasi publik.
        </p>
    </div>

    <a href="{{ route('admin.rekap.permohonan.index') }}"
       class="btn btn-outline-primary d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-bar-chart-line"></i>
        Rekap Permohonan
    </a>
</div>


@if(session('success'))
<div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 fw-bold">Data Registrasi</h5>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="permohonanTable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>No. Registrasi</th>
                        <th class="text-center">Status</th>
                        <th>Identitas Pemohon</th>
                        <th>Detail Kategorisasi</th>
                        <th>Waktu Masuk</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($permohonan as $index => $item)
                    <tr>
                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                        <td>
                            <a href="{{ route('admin.permohonan.show', $item) }}" class="registrasi-link">
                                {{ $item->nomor_registrasi }}
                            </a>
                        </td>
                        <td class="text-center">
                            @php
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
                            <span class="badge status-badge {{ $class }}">
                                {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->nama }}</div>
                            <div class="small text-muted text-truncate" style="max-width: 200px;">
                                <i class="bi bi-envelope me-1"></i>{{ $item->email }}
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
                                        <i class="bi bi-file-earmark-text"></i> {{ $item->jenis_permohonan_informasi_label }}
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

                                {{-- Menambahkan Jenis Permintaan yang mungkin sebelumnya hilang --}}
                                @if($item->jenis_permintaan_label)
                                    <span class="badge badge-soft badge-soft-secondary" title="Jenis Permintaan">
                                        <i class="bi bi-hand-index"></i> {{ $item->jenis_permintaan_label }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</div>
                            <div class="text-muted small">{{ $item->created_at?->format('H:i') ?? '' }} WIB</div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.permohonan.show', $item) }}" class="btn-action" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn-action delete" onclick="confirmDelete({{ $item->id }})" title="Hapus">
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
    $('#permohonanTable').DataTable({
        pageLength: 10,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Cari nomor atau nama...",
            lengthMenu: "_MENU_",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            paginate: { 
                previous: "<i class='bi bi-arrow-left'></i>", 
                next: "<i class='bi bi-arrow-right'></i>" 
            }
        },
        dom: "<'row p-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row p-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    // Styling tambahan untuk input search DataTables agar lebih clean
    $('.dataTables_filter input').addClass('form-control form-control-sm border-secondary-subtle');
    $('.dataTables_length select').addClass('form-select form-select-sm border-secondary-subtle');
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data permohonan ini secara permanen?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush