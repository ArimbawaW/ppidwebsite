@extends('layouts.admin')

@section('title', 'Manajemen Keberatan')

@push('styles')
<style>
/* ===== STANDAR TABEL ADMIN (SAMA DENGAN PERMOHONAN) ===== */
.table .badge {
    display: inline-block;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    line-height: 1;
    border-radius: 0.25rem;
}

.badge-success { background-color: #198754; color: #fff; }
.badge-warning { background-color: #ffc107; color: #212529; }
.badge-danger  { background-color: #dc3545; color: #fff; }
.badge-info    { background-color: #0dcaf0; color: #fff; }

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group-custom {
    display: inline-flex;
    gap: 4px;
}

.table .fas {
    margin-right: 4px;
}

/* ===== SCROLL HORIZONTAL ===== */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Opsional: Custom scrollbar styling */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Daftar Keberatan</h2>
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-triangle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-database me-2"></i>
            Data Keberatan
        </h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="keberatanTable" style="white-space: nowrap;">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="50">No</th>
                        <th width="160">No. Registrasi</th>
                        <th width="200">No. Permohonan</th>
                        <th width="150">Nama Pemohon</th>
                        <th width="180">Alasan Keberatan</th>
                        <th class="text-center" width="120">Status</th>
                        <th width="150">Tanggal</th>
                        <th class="text-center" width="120">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- MODAL QUICK VIEW -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Keberatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    $('#keberatanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.keberatan.index') }}",
        order: [[6, 'desc']],
        scrollX: true,
        columns: [
            { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
            { data: 'nomor_registrasi' },
            { data: 'nomor_registrasi_permohonan' },
            { data: 'nama_pemohon' },
            { data: 'alasan_keberatan' },
            { 
                data: 'status',
                className: 'text-center',
                orderable: true,
                searchable: true
            },
            { data: 'created_at' },
            {
                data: 'action',
                className: 'text-center',
                orderable: false,
                searchable: false
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            zeroRecords: "Tidak ada data keberatan",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya"
            }
        }
    });
});

function quickView(id) {
    $('#quickViewModal').modal('show');
    $('#quickViewContent').load('/admin/keberatan/' + id + '/quick-view');
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus keberatan ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush