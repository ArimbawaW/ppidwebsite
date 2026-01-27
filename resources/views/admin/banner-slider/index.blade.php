@extends('layouts.admin')

@section('title', 'Kelola Banner Slider - Admin PPID')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #003f54;">
            <i class="bi bi-images me-2"></i>Kelola Banner Slider
        </h2>
        <a href="{{ route('admin.banner-slider.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Banner
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            
            @if($banners->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Preview</th>
                                <th width="25%">Judul</th>
                                <th width="10%">Urutan</th>
                                <th width="10%">Status</th>
                                <th width="15%">Tanggal Upload</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $index => $banner)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($banner->gambar) }}" 
                                             alt="Banner Preview" 
                                             class="img-thumbnail"
                                             style="max-height: 80px; width: auto;">
                                    </td>
                                    <td>
                                        <strong>{{ $banner->judul ?: 'Tanpa Judul' }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $banner->urutan }}</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" 
                                                   type="checkbox" 
                                                   role="switch"
                                                   data-id="{{ $banner->id }}"
                                                   {{ $banner->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label status-label-{{ $banner->id }}">
                                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $banner->created_at->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.banner-slider.edit', $banner->id) }}" 
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete({{ $banner->id }})"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <form id="delete-form-{{ $banner->id }}" 
                                              action="{{ route('admin.banner-slider.destroy', $banner->id) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-images" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="mt-3 text-muted">Belum ada banner slider.</p>
                    <a href="{{ route('admin.banner-slider.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Banner Pertama
                    </a>
                </div>
            @endif

        </div>
    </div>

    <!-- Info Box -->
    <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Tips:</strong> Gunakan kolom "Urutan" untuk menentukan posisi tampil banner. Angka lebih kecil akan tampil lebih dulu. 
        Ukuran gambar yang disarankan: minimal 1440 x 410 pixel. dengan rasio 3,5:1 untuk hasil terbaik.
    </div>

</div>
@endsection

@push('scripts')
<script>
// Toggle Status
document.querySelectorAll('.toggle-status').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const bannerId = this.dataset.id;
        const isChecked = this.checked;
        
        fetch(`/admin/banner-slider/${bannerId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const label = document.querySelector(`.status-label-${bannerId}`);
                label.textContent = data.is_active ? 'Aktif' : 'Nonaktif';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.checked = !isChecked; // Kembalikan ke status sebelumnya
        });
    });
});

// Confirm Delete
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus banner ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush