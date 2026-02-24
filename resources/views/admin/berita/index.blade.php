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

.badge.status-scheduled {
    background-color: #007bff !important;
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

/* Custom Header Styling sesuai gambar user */
.custom-card-header {
    background-color: #1a6881 !important; /* Warna biru sesuai screenshot */
    color: #ffffff !important;
}

.custom-card-header h5, 
.custom-card-header i {
    color: #ffffff !important;
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

@media (max-width: 768px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
    }
}
</style>
@endpush

@section('content')

<div class="page-header d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Kelola Berita</h2>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Berita
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.berita.index') }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="{{ request('search') }}">
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

<div class="card border-0 shadow-sm">
    <div class="card-header custom-card-header py-3">
        <h5 class="mb-0">
            <i class="bi bi-newspaper me-2"></i>Daftar Berita
        </h5>
    </div>

    <div class="card-body">
        @if($berita->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Gambar</th>
                        <th width="30%">Judul</th>
                        <th width="12%">Kategori</th>
                        <th width="12%">Status</th>
                        <th width="8%">Views</th>
                        <th width="13%">Tanggal Tayang</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $index => $item)
                    <tr>
                        <td>{{ $berita->firstItem() + $index }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="news-thumbnail">
                            @else
                                <div class="news-thumbnail-placeholder">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ Str::limit($item->judul, 50) }}</div>
                            <small class="text-muted">Oleh: {{ $item->user->name ?? 'Admin' }}</small>
                        </td>
                        <td>
                            @php
                                $badgeClass = match($item->kategori) {
                                    'berita' => 'bg-primary',
                                    'artikel' => 'bg-info text-dark',
                                    'pengumuman' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($item->kategori) }}</span>
                        </td>
                        <td>
                            @if(!$item->is_published)
                                <span class="badge status-draft">Draft</span>
                            @elseif($item->published_at && $item->published_at > now())
                                <span class="badge status-scheduled" data-bs-toggle="tooltip" title="Akan tayang otomatis">Scheduled</span>
                            @else
                                <span class="badge status-published">Published</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted"><i class="bi bi-eye me-1"></i>{{ $item->views }}</span>
                        </td>
                        <td>
                            <div class="small fw-bold">
                                {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                            </div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-clock me-1"></i>{{ $item->published_at ? $item->published_at->format('H:i') : '' }}
                            </div>
                        </td>
                        <td>
                            <div class="btn-group-action">
                                <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn btn-sm btn-warning text-white" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})" data-bs-toggle="tooltip" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
            <p class="text-muted small">
                Menampilkan {{ $berita->firstItem() }}–{{ $berita->lastItem() }} dari {{ $berita->total() }} berita
            </p>
            {{ $berita->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-newspaper fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Tidak ada berita ditemukan</h5>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary mt-3">Buat Berita Baru</a>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltip init
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush