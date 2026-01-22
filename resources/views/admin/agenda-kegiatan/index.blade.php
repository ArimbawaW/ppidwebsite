@extends('layouts.admin')

@section('title', 'Kelola Agenda Kegiatan')

@push('styles')
<style>
/* Badge Status Styling */
.badge.status-upcoming {
    background-color: #0dcaf0 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-ongoing {
    background-color: #ffc107 !important;
    color: #212529 !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-selesai-agenda {
    background-color: #6c757d !important;
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
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Kelola Agenda Kegiatan</h2>
    </div>
    <div>
        <a href="{{ route('admin.agenda-kegiatan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Agenda
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
            <i class="bi bi-calendar-event me-2"></i>
            Daftar Agenda Kegiatan
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="25%">Judul</th>
                        <th width="10%">Waktu</th>
                        <th width="20%">Lokasi</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agenda as $index => $item)
                    <tr>
                        <td>{{ $agenda->firstItem() + $index }}</td>
                        <td>{{ $item->tanggal_format }}</td>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td>
                            @if($item->waktu_mulai)
                                {{ date('H:i', strtotime($item->waktu_mulai)) }} WIB
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->lokasi ?? '-' }}</td>
                        <td>
                            @if($item->status === 'upcoming')
                                <span class="badge status-upcoming">Akan Datang</span>
                            @elseif($item->status === 'ongoing')
                                <span class="badge status-ongoing">Berlangsung</span>
                            @else
                                <span class="badge status-selesai-agenda">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group-action">
                                <!-- Edit -->
                                <a href="{{ route('admin.agenda-kegiatan.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Agenda">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Agenda"
                                        onclick="confirmDelete({{ $item->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('admin.agenda-kegiatan.destroy', $item->id) }}"
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
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                            Belum ada agenda kegiatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-end mt-4">
            {{ $agenda->links() }}
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
    if (confirm('Yakin ingin menghapus agenda ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush