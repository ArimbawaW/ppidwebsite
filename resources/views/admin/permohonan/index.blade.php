@extends('layouts.admin')

@section('title', 'Daftar Permohonan')

@push('styles')
<style>
.table .badge {
    display: inline-block !important;
    padding: 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    line-height: 1 !important;
    border-radius: 0.25rem !important;
}

.badge-primary { background-color: #0d6efd !important; color: #fff !important; }
.badge-success { background-color: #198754 !important; color: #fff !important; }
.badge-warning { background-color: #ffc107 !important; color: #212529 !important; }
.badge-info    { background-color: #0dcaf0 !important; color: #212529 !important; }
.badge-danger  { background-color: #dc3545 !important; color: #fff !important; }

.btn-group-custom {
    display: inline-flex;
    gap: 6px;
}

/* Fix untuk table - pastikan tidak terpotong */
.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
    margin-bottom: 1rem;
}

#permohonanTable {
    width: 100% !important;
    table-layout: auto !important;
}

/* Pastikan kolom tidak terpotong */
#permohonanTable th,
#permohonanTable td {
    white-space: nowrap;
}

/* Kolom yang bisa wrap (untuk text panjang) */
#permohonanTable td:nth-child(4),  /* Nama Pemohon */
#permohonanTable td:nth-child(5) { /* Kontak */
    white-space: normal;
    min-width: 180px;
}

.kategori-cell { 
    min-width: 150px !important;
}

.aksi-cell { 
    min-width: 120px !important;
    text-align: center !important;
}

/* Override DataTables wrapper untuk scrolling */
.dataTables_wrapper {
    width: 100%;
}

.dataTables_wrapper .dataTables_scroll {
    width: 100%;
}

.dataTables_wrapper .dataTables_scrollBody {
    overflow-x: auto !important;
    width: 100% !important;
}

.card-body {
    padding: 1.5rem;
    overflow-x: auto;
}

/* Pastikan button group tidak wrap */
.btn-group-custom {
    white-space: nowrap;
}
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Daftar Permohonan</h2>
        <p>Manajemen dan pemantauan permohonan layanan</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-database me-2"></i>
            Data Permohonan
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="permohonanTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th style="min-width: 200px;">No. Registrasi</th>
                        <th class="text-center kategori-cell">Kategori</th>
                        <th style="min-width: 180px;">Nama Pemohon</th>
                        <th style="min-width: 200px;">Kontak</th>
                        <th style="min-width: 120px;">Tanggal</th>
                        <th class="text-center" style="min-width: 120px;">Status</th>
                        <th class="text-center aksi-cell">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($permohonan as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>

                        <td>
                            <a href="{{ route('admin.permohonan.show', $item) }}"
                               class="fw-bold text-primary">
                                {{ $item->nomor_registrasi }}
                            </a>
                        </td>

                        <td class="text-center kategori-cell">
                            @if($item->kategori_pemohon === 'perorangan')
                                <span class="badge badge-primary">
                                    <i class="bi bi-person"></i> Perorangan
                                </span>
                            @elseif($item->kategori_pemohon === 'kelompok')
                                <span class="badge badge-success">
                                    <i class="bi bi-people"></i> Kelompok
                                </span>
                            @elseif($item->kategori_pemohon === 'badan_hukum')
                                <span class="badge badge-warning">
                                    <i class="bi bi-building"></i> Badan Hukum
                                </span>
                            @endif
                        </td>

                        <td>
                            <strong>{{ $item->nama }}</strong><br>
                            <small class="text-muted">{{ $item->pekerjaan }}</small>
                        </td>

                        <td>
                            <small>
                                <i class="bi bi-envelope"></i> {{ $item->email }}<br>
                                <i class="bi bi-telephone"></i> {{ $item->no_telepon }}
                            </small>
                        </td>

                        <td>
                            <small>
                                {{ $item->created_at->format('d/m/Y') }}<br>
                                {{ $item->created_at->format('H:i') }} WIB
                            </small>
                        </td>

                        <td class="text-center">
                            @if($item->status === 'pending')
                                <span class="badge badge-warning">
                                    <i class="bi bi-clock"></i> Pending
                                </span>
                            @elseif($item->status === 'diproses')
                                <span class="badge badge-info">
                                    <i class="bi bi-arrow-repeat"></i> Diproses
                                </span>
                            @elseif($item->status === 'disetujui')
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle"></i> Disetujui
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="bi bi-x-circle"></i> Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="text-center aksi-cell">
                            <div class="btn-group-custom">
                                <a href="{{ route('admin.permohonan.show', $item) }}"
                                   class="btn btn-sm btn-primary"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-danger"
                                        onclick="confirmDelete({{ $item->id }})"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <form id="delete-form-{{ $item->id }}"
                                  action="{{ route('admin.permohonan.destroy', $item) }}"
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
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
    var table = $('#permohonanTable').DataTable({
        pageLength: 10,
        ordering: true,
        scrollX: true,
        scrollCollapse: true,
        autoWidth: false,
        processing: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0–0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Tidak ada data permohonan",
            processing: "Memproses...",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya"
            }
        },
        columnDefs: [
            { orderable: false, targets: [7] },
            { width: "50px", targets: 0 },
            { width: "200px", targets: 1 },
            { width: "150px", targets: 2 },
            { width: "180px", targets: 3 },
            { width: "200px", targets: 4 },
            { width: "120px", targets: 5 },
            { width: "120px", targets: 6 },
            { width: "120px", targets: 7 }
        ],
        fixedColumns: false,
        scrollXInner: "100%"
    });

    // Force redraw after initialization
    setTimeout(function() {
        table.columns.adjust().draw();
    }, 100);
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus permohonan ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush