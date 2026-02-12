@extends('layouts.admin')

@section('title', 'Manajemen Berita - PPID Admin')

@push('styles')
<style>
/* Badge Status Styling */
.badge.status-published {
    background-color: #28a745 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-draft {
    background-color: #6c757d !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

/* Button Group Custom Styling */
.btn-group-action {
    display: inline-flex;
    gap: 6px;
    white-space: nowrap;
}

.btn-group-action .btn {
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem !important;
}

.btn-group-action .btn i {
    font-size: 0.875rem;
}

/* Thumbnail Styling */
.news-thumbnail {
    width: 60px;
    height: 40px;
    object-fit: cover;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.news-thumbnail-placeholder {
    width: 60px;
    height: 40px;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
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
        flex-direction: row;
        gap: 4px;
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
        <h2>Kelola Berita</h2>
    </div>
    <div>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Berita
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- FILTER CARD -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.berita.index') }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari judul berita..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="berita" {{ request('kategori') === 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="artikel" {{ request('kategori') === 'artikel' ? 'selected' : '' }}>Artikel</option>
                        <option value="pengumuman" {{ request('kategori') === 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-newspaper me-2"></i>
            Daftar Berita
        </h5>
    </div>

    <div class="card-body">

        @if($berita->count())

        <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="table table-hover align-middle" style="min-width: 900px;">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Gambar</th>
                        <th width="30%">Judul</th>
                        <th width="12%">Kategori</th>
                        <th width="10%">Status</th>
                        <th width="8%">Views</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $index => $item)
                    <tr>
                        <td>{{ $berita->firstItem() + $index }}</td>

                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     alt="{{ $item->judul }}"
                                     class="news-thumbnail">
                            @else
                                <div class="news-thumbnail-placeholder">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>

                        <td>
                            <strong>{{ Str::limit($item->judul, 50) }}</strong>
                        </td>

                        <td style="white-space: nowrap;">
                            @if($item->kategori === 'berita')
                                <span class="badge bg-primary">Berita</span>
                            @elseif($item->kategori === 'artikel')
                                <span class="badge bg-info">Artikel</span>
                            @else
                                <span class="badge bg-warning text-dark">Pengumuman</span>
                            @endif
                        </td>

                        <td style="white-space: nowrap;">
                            @if($item->is_published)
                                <span class="badge status-published">Published</span>
                            @else
                                <span class="badge status-draft">Draft</span>
                            @endif
                        </td>

                        <td style="white-space: nowrap;">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-eye me-1"></i>{{ $item->views }}
                            </span>
                        </td>

                        <td style="white-space: nowrap;">
                            <small class="text-muted">
                                {{ $item->created_at->format('d M Y') }}
                            </small>
                        </td>

                        <td>
                            <div class="btn-group-action">
                                <!-- Edit -->
                                <a href="{{ route('admin.berita.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Berita">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Berita"
                                        onclick="confirmDelete({{ $item->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('admin.berita.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
            <p class="text-muted mb-2 mb-md-0">
                Menampilkan {{ $berita->firstItem() }}–{{ $berita->lastItem() }}
                dari {{ $berita->total() }} data
            </p>
            {{ $berita->links() }}
        </div>

        @else

        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <p class="text-muted mb-3">Belum ada berita yang tersedia</p>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Berita Pertama
            </a>
        </div>

        @endif

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
    if (confirm('Yakin ingin menghapus berita ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush