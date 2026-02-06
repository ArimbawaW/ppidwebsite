@extends('layouts.admin')

@section('title', 'Galeri - PPID Admin')

@push('styles')
<style>
.badge.status-aktif-galeri {
    background-color: #28a745 !important;
    color: #fff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-nonaktif-galeri {
    background-color: #6c757d !important;
    color: #fff !important;
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

/* Gallery Image Styling */
.gallery-thumbnail {
    max-width: 100px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    will-change: transform;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}

.gallery-thumbnail:hover {
    transform: scale(1.05);
    cursor: pointer;
}

/* Prevent modal flickering */
.modal {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
}

.modal-body img {
    display: block;
    max-width: 100%;
    height: auto;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}

/* Modal image container */
.modal-image-container {
    position: relative;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-image-container img {
    max-height: 80vh;
    width: auto;
    object-fit: contain;
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
        <h2>Kelola Galeri</h2>
    </div>
    <div>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Galeri
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
            <i class="bi bi-images me-2"></i>
            Daftar Galeri
        </h5>
    </div>

    <div class="card-body">

        @if($galeri->count())

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Gambar</th>
                        <th width="30%">Judul</th>
                        <th width="12%">Status</th>
                        <th width="15%">Tanggal</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galeri as $index => $item)
                    <tr>
                        <td>{{ $galeri->firstItem() + $index }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     alt="{{ $item->judul }}"
                                     class="gallery-thumbnail"
                                     onclick="showImageModal({{ $item->id }})"
                                     loading="lazy">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td>
                            @if($item->is_active)
                                <span class="badge status-aktif-galeri">Aktif</span>
                            @else
                                <span class="badge status-nonaktif-galeri">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group-action">
                                <!-- Edit -->
                                <a href="{{ route('admin.galeri.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Galeri">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Galeri"
                                        onclick="confirmDelete({{ $item->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('admin.galeri.destroy', $item->id) }}"
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
        <div class="d-flex justify-content-end mt-4">
            {{ $galeri->links() }}
        </div>

        @else

        <div class="text-center py-5">
            <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
            <p class="text-muted mb-3">Belum ada galeri foto.</p>
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Galeri Pertama
            </a>
        </div>

        @endif

    </div>
</div>

<!-- Modal untuk Preview Gambar (Single Modal) -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <div class="modal-image-container">
                    <img id="modalPreviewImage" src="" alt="" class="img-fluid">
                </div>
            </div>
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
    if (confirm('Yakin ingin menghapus galeri ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Show image modal function
let imagePreviewModal = null;

function showImageModal(itemId) {
    // Cari gambar berdasarkan ID
    const thumbnailImg = event.target;
    const imgSrc = thumbnailImg.src;
    const imgAlt = thumbnailImg.alt;
    
    // Update modal content
    const modalImage = document.getElementById('modalPreviewImage');
    const modalTitle = document.getElementById('imagePreviewModalLabel');
    
    modalTitle.textContent = imgAlt;
    modalImage.src = imgSrc;
    modalImage.alt = imgAlt;
    
    // Show modal
    if (!imagePreviewModal) {
        imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    }
    imagePreviewModal.show();
}

// Preload images untuk mencegah blinking
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    
    thumbnails.forEach(function(thumb) {
        // Preload image
        const img = new Image();
        img.src = thumb.src;
    });
});
</script>
@endpush