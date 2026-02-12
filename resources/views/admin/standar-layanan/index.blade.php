@extends('layouts.admin')

@section('title', 'Manajemen Standar Layanan')

@push('styles')
<style>
    button, a.btn, .btn {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .table td:nth-child(3) {
        text-align: center !important;
        vertical-align: middle !important;
    }

    /* Button Group Styling */
    .btn-group-action {
        display: inline-flex;
        gap: 4px;
        white-space: nowrap;
    }

    /* Table Responsive Enhancement */
    @media (max-width: 768px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-responsive table {
            margin-bottom: 0;
        }
        
        .btn-group-action {
            flex-wrap: nowrap;
        }
        
        .btn-group-action .btn {
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Kelola Standar Layanan</h2>
    </div>
    <div>
        <a href="{{ route('admin.standar-layanan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Standar Layanan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-clipboard-check me-2"></i>
            Daftar Standar Layanan
        </h5>
    </div>

    <div class="card-body">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.standar-layanan.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari nama layanan..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="table table-hover align-middle" style="min-width: 600px;">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="65%">Nama Layanan</th>
                        <th width="10%" class="text-center">Urutan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($standarLayanan as $index => $layanan)
                        <tr>
                            <td>{{ $standarLayanan->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $layanan->nama_layanan }}</strong>
                            </td>
                            <td class="text-center" style="white-space: nowrap;">
                                <span class="badge bg-secondary">
                                    {{ $layanan->urutan }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group-action">
                                    <a href="{{ route('admin.standar-layanan.edit', $layanan) }}"
                                       class="btn btn-warning btn-sm text-white"
                                       data-bs-toggle="tooltip"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.standar-layanan.destroy', $layanan) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus standar layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-3">Belum ada data standar layanan</p>
                                <a href="{{ route('admin.standar-layanan.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Standar Layanan Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <p class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $standarLayanan->firstItem() ?? 0 }}–{{ $standarLayanan->lastItem() ?? 0 }}
                dari {{ $standarLayanan->total() }} data
            </p>
            {{ $standarLayanan->links() }}
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});
</script>
@endpush