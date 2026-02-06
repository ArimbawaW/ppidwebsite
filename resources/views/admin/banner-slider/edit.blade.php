@extends('layouts.admin')

@section('title', 'Edit Banner Slider - Admin PPID')

@push('styles')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    .cropper-container {
        max-height: 500px;
    }
    
    #cropperImage {
        max-width: 100%;
        display: block;
    }
    
    .modal-cropper .modal-body {
        padding: 15px;
    }
    
    .cropper-controls {
        padding: 15px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
    
    /* Toolbar styling */
    .cropper-toolbar {
        background: #f8f9fa !important;
    }
    
    .cropper-toolbar .btn {
        margin: 0 2px;
    }
    
    .cropper-toolbar .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    .cropper-toolbar .btn:hover {
        background-color: #e9ecef;
    }
    
    .cropper-toolbar .btn.active:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
    
    /* Make cropper more responsive */
    .cropper-wrapper {
        max-height: 400px;
        overflow: hidden;
    }
    
    @media (max-width: 768px) {
        .cropper-wrapper {
            max-height: 300px;
        }
        
        .cropper-toolbar .btn-group {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

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
                           accept="image/*">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, WEBP. Maksimal 5MB. Kosongkan jika tidak ingin mengganti gambar.
                    </small>
                    <small class="text-info d-block mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Gambar akan otomatis di-crop sesuai rasio yang disarankan (3.5:1)
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

<!-- Modal Cropper -->
<div class="modal fade modal-cropper" id="cropperModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-crop me-2"></i>Crop Gambar Banner
                </h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Sesuaikan area gambar yang akan ditampilkan (Rasio: 3.5:1)
                    </small>
                </div>
                
                <!-- Toolbar Controls -->
                <div class="cropper-toolbar text-center mb-3 p-2 bg-light border rounded">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="zoomIn" title="Zoom In">
                            <i class="bi bi-zoom-in"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="zoomOut" title="Zoom Out">
                            <i class="bi bi-zoom-out"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="resetCrop" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="moveMode" title="Mode: Geser Gambar">
                            <i class="bi bi-arrows-move"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="cropMode" title="Mode: Resize Crop Box">
                            <i class="bi bi-bounding-box"></i>
                        </button>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            💡 Tips: Scroll mouse untuk zoom, Drag untuk geser gambar/crop box
                        </small>
                    </div>
                </div>
                
                <div class="cropper-wrapper">
                    <img id="cropperImage" src="" alt="Gambar untuk di-crop">
                </div>
            </div>
            <div class="cropper-controls">
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" id="cancelCrop">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="cropButton">
                        <i class="bi bi-check-circle me-2"></i>Crop & Gunakan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Cropper.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<!-- Banner Crop Script (INLINE - karena Bootstrap dari Vite) -->
<script>
(function() {
    'use strict';
    
    let cropper = null;
    let cropperModal = null;
    let currentFile = null;
    
    // Debug mode
    const DEBUG = true;
    
    function log(msg, data) {
        if (DEBUG) console.log('[Banner Crop]', msg, data || '');
    }
    
    // Wait for DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        log('Initializing...');
        
        const fileInput = document.getElementById('gambar');
        const modalEl = document.getElementById('cropperModal');
        
        if (!fileInput || !modalEl) {
            console.error('[Banner Crop] Required elements not found!');
            return;
        }
        
        // Check Bootstrap (dari Vite)
        if (typeof bootstrap === 'undefined') {
            console.error('[Banner Crop] Bootstrap not loaded! Check Vite build.');
            return;
        }
        
        // Check Cropper
        if (typeof Cropper === 'undefined') {
            console.error('[Banner Crop] Cropper.js not loaded!');
            return;
        }
        
        log('All dependencies loaded');
        
        cropperModal = new bootstrap.Modal(modalEl);
        
        // Event listeners
        fileInput.addEventListener('change', handleFileSelect);
        document.getElementById('cropButton')?.addEventListener('click', handleCrop);
        document.getElementById('cancelCrop')?.addEventListener('click', handleCancel);
        
        // Toolbar
        document.getElementById('zoomIn')?.addEventListener('click', (e) => {
            e.preventDefault();
            if (cropper) cropper.zoom(0.1);
        });
        
        document.getElementById('zoomOut')?.addEventListener('click', (e) => {
            e.preventDefault();
            if (cropper) cropper.zoom(-0.1);
        });
        
        document.getElementById('resetCrop')?.addEventListener('click', (e) => {
            e.preventDefault();
            if (cropper) cropper.reset();
        });
        
        document.getElementById('moveMode')?.addEventListener('click', function(e) {
            e.preventDefault();
            if (cropper) {
                cropper.setDragMode('move');
                this.classList.add('active');
                document.getElementById('cropMode')?.classList.remove('active');
            }
        });
        
        document.getElementById('cropMode')?.addEventListener('click', function(e) {
            e.preventDefault();
            if (cropper) {
                cropper.setDragMode('crop');
                this.classList.add('active');
                document.getElementById('moveMode')?.classList.remove('active');
            }
        });
        
        log('Initialization complete');
    }
    
    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        log('File selected', file.name);
        
        // Validate
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid! Gunakan JPG, PNG, atau WEBP');
            e.target.value = '';
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB');
            e.target.value = '';
            return;
        }
        
        currentFile = file;
        showCropperModal(file);
    }
    
    function showCropperModal(file) {
        log('Loading image...');
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('cropperImage');
            img.src = e.target.result;
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropperModal.show();
            
            setTimeout(() => {
                log('Creating Cropper instance...');
                
                cropper = new Cropper(img, {
                    aspectRatio: 3.5 / 1,
                    viewMode: 2,
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: true,
                    background: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true,
                    responsive: true,
                    modal: true,
                    scalable: true,
                    zoomable: true,
                    zoomOnWheel: true,
                    wheelZoomRatio: 0.1,
                    movable: true,
                    minCropBoxWidth: 100,
                    minCropBoxHeight: 28,
                    ready: function() {
                        log('Cropper ready!');
                        document.getElementById('moveMode')?.classList.add('active');
                    }
                });
            }, 300);
        };
        
        reader.readAsDataURL(file);
    }
    
    function handleCrop() {
        if (!cropper) return;
        
        log('Cropping...');
        
        const btn = document.getElementById('cropButton');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
        
        const canvas = cropper.getCroppedCanvas({
            width: 1440,
            height: 410,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        canvas.toBlob(function(blob) {
            const file = new File([blob], currentFile.name, {
                type: currentFile.type,
                lastModified: Date.now()
            });
            
            log('Crop complete', Math.round(blob.size/1024) + 'KB');
            
            // Update input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('gambar').files = dataTransfer.files;
            
            // Show preview
            const preview = document.getElementById('preview');
            const previewBox = document.getElementById('imagePreview');
            preview.src = canvas.toDataURL();
            previewBox.style.display = 'block';
            
            cropperModal.hide();
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Crop & Gunakan';
            
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }, currentFile.type, 0.95);
    }
    
    function handleCancel() {
        log('Cancelled');
        document.getElementById('gambar').value = '';
        cropperModal.hide();
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        document.getElementById('imagePreview').style.display = 'none';
    }
})();
</script>
@endpush