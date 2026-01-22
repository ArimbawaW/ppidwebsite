@extends('layouts.admin')

@section('title', 'Kelola Halaman Statis')

@section('styles')
<style>
.badge.status-aktif-halaman {
    background-color: #28a745 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-nonaktif-halaman {
    background-color: #dc3545 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

/* Button Group Custom Styling */
.btn-group-action {
    display: inline-flex;
    gap: 6px;
}

.btn-group-action .btn {
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem !important;
}

.btn-group-action .btn i {
    font-size: 0.875rem;
}

/* Responsive button sizing */
@media (max-width: 768px) {
    .btn-group-action {
        flex-direction: column;
        gap: 4px;
    }
    
    .btn-group-action .btn {
        width: 100%;
    }
}
</style>
@endsection

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Kelola Halaman Statis</h2>
    </div>
    <div>
        <a href="{{ route('admin.halaman-statis.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Halaman
        </a>
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
            <i class="bi bi-file-earmark-text me-2"></i>
            Daftar Halaman Statis
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Judul</th>
                        <th width="25%">Slug</th>
                        <th width="12%">Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($halaman as $index => $item)
                    <tr>
                        <td>{{ $halaman->firstItem() + $index }}</td>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td><code class="text-primary">{{ $item->slug }}</code></td>
                        <td>
                            @if($item->is_active)
                                <span class="badge status-aktif-halaman">Aktif</span>
                            @else
                                <span class="badge status-nonaktif-halaman">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group-action">

                                <!-- Lihat Frontend -->
                                <a href="{{ route('halaman-statis.show', $item->slug) }}"
                                   class="btn btn-sm btn-info text-white"
                                   target="_blank"
                                   rel="noopener"
                                   data-bs-toggle="tooltip"
                                   title="Lihat Halaman">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.halaman-statis.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Halaman">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Halaman"
                                        onclick="confirmDelete({{ $item->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('admin.halaman-statis.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada halaman statis
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-end mt-4">
            {{ $halaman->links() }}
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

// Confirm delete function
function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus halaman ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush