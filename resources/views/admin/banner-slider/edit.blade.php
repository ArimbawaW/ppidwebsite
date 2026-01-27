@extends('layouts.admin')

@section('title', 'Edit Banner Slider - Admin PPID')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #003f54;">
            <i class="bi bi-pencil me-2"></i>Edit Banner Slider
        </h2>
        <a href="{{ route('admin.banner-slider.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Card Form -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.banner-slider.update', $bannerSlider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Judul Banner -->
                <div class="mb-4">
                    <label for="judul" class="form-label fw-semibold">
                        Judul Banner <small class="text-muted">(Opsional)</small>
                    </label>
                    <input type="text" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" 
                           name="judul"
                           placeholder="Contoh: Selamat Datang di PPID"
                           value="{{ old('judul', $bannerSlider->judul) }}">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Judul hanya untuk identifikasi di admin panel, tidak ditampilkan di website.</small>
                </div>

                <!-- Gambar Saat Ini -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Gambar Saat Ini</label>
                    <div>
                        <img src="{{ asset($bannerSlider->gambar) }}" 
                             alt="Current Banner" 
                             class="img-thumbnail"
                             style="max-height: 200px;">
                    </div>
                </div>

                <!-- Upload Gambar Baru -->
                <div class="mb-4">
                    <label for="gambar" class="form-label fw-semibold">
                        Ganti Gambar Banner <small class="text-muted">(Opsional)</small>
                    </label>
                    <input type="file" 
                           class="form-control @error('gambar') is-invalid @enderror" 
                           id="gambar" 
                           name="gambar"
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, WEBP. Maksimal 5MB. Kosongkan jika tidak ingin mengganti gambar.
                    </small>

                    <!-- Preview Image -->
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <p class="fw-semibold mb-2">Preview Gambar Baru:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 300px;">
                    </div>
                </div>

                <!-- Urutan -->
                <div class="mb-4">
                    <label for="urutan" class="form-label fw-semibold">
                        Urutan Tampil <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           class="form-control @error('urutan') is-invalid @enderror" 
                           id="urutan" 
                           name="urutan"
                           min="0"
                           value="{{ old('urutan', $bannerSlider->urutan) }}"
                           required>
                    @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Angka lebih kecil akan ditampilkan lebih dulu. Contoh: 1, 2, 3, dst.</small>
                </div>

                <!-- Status Aktif -->
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               role="switch" 
                               id="is_active" 
                               name="is_active"
                               value="1"
                               {{ old('is_active', $bannerSlider->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">
                            Aktifkan Banner
                        </label>
                    </div>
                    <small class="text-muted">Banner hanya akan tampil di website jika status aktif.</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Update Banner
                    </button>
                    <a href="{{ route('admin.banner-slider.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush