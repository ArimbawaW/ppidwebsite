/**
 * Banner Image Cropper v2.0
 * Menggunakan Cropper.js untuk crop gambar banner
 * With debugging and better error handling
 */

let cropper = null;
let cropperModal = null;
let currentFile = null;

// Debug mode
const DEBUG = true;

function log(message, data = null) {
    if (DEBUG) {
        console.log('[Banner Crop]', message, data || '');
    }
}

// Inisialisasi saat DOM ready
document.addEventListener('DOMContentLoaded', function() {
    log('DOM Content Loaded, initializing cropper...');
    initializeCropper();
});

function initializeCropper() {
    log('Starting initialization...');
    
    const fileInput = document.getElementById('gambar');
    const cropperModalEl = document.getElementById('cropperModal');
    
    if (!fileInput) {
        console.error('[Banner Crop] File input with id="gambar" not found!');
        return;
    }
    
    if (!cropperModalEl) {
        console.error('[Banner Crop] Modal with id="cropperModal" not found!');
        return;
    }
    
    log('Elements found, checking Bootstrap...');
    
    // Check jika Bootstrap tersedia
    if (typeof bootstrap === 'undefined') {
        console.error('[Banner Crop] Bootstrap is not loaded!');
        return;
    }
    
    // Check jika Cropper tersedia
    if (typeof Cropper === 'undefined') {
        console.error('[Banner Crop] Cropper.js is not loaded!');
        return;
    }
    
    log('Bootstrap and Cropper.js loaded successfully');
    
    cropperModal = new bootstrap.Modal(cropperModalEl);
    
    // Event listener untuk input file
    fileInput.addEventListener('change', handleFileSelect);
    log('File input event listener attached');
    
    // Event listener untuk tombol crop
    const cropButton = document.getElementById('cropButton');
    if (cropButton) {
        cropButton.addEventListener('click', handleCrop);
        log('Crop button event listener attached');
    } else {
        console.warn('[Banner Crop] Crop button not found');
    }
    
    // Event listener untuk tombol cancel
    const cancelButton = document.getElementById('cancelCrop');
    if (cancelButton) {
        cancelButton.addEventListener('click', handleCancelCrop);
        log('Cancel button event listener attached');
    } else {
        console.warn('[Banner Crop] Cancel button not found');
    }
    
    // Event listeners untuk toolbar controls
    setupToolbarControls();
    
    log('Initialization completed successfully!');
}

function setupToolbarControls() {
    log('Setting up toolbar controls...');
    
    // Zoom In
    const zoomInBtn = document.getElementById('zoomIn');
    if (zoomInBtn) {
        zoomInBtn.addEventListener('click', function(e) {
            e.preventDefault();
            log('Zoom In clicked');
            if (cropper) {
                cropper.zoom(0.1);
            }
        });
    }
    
    // Zoom Out
    const zoomOutBtn = document.getElementById('zoomOut');
    if (zoomOutBtn) {
        zoomOutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            log('Zoom Out clicked');
            if (cropper) {
                cropper.zoom(-0.1);
            }
        });
    }
    
    // Reset
    const resetBtn = document.getElementById('resetCrop');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            log('Reset clicked');
            if (cropper) {
                cropper.reset();
            }
        });
    }
    
    // Move Mode
    const moveModeBtn = document.getElementById('moveMode');
    if (moveModeBtn) {
        moveModeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            log('Move Mode clicked');
            if (cropper) {
                cropper.setDragMode('move');
                this.classList.add('active');
                document.getElementById('cropMode')?.classList.remove('active');
            }
        });
    }
    
    // Crop Mode
    const cropModeBtn = document.getElementById('cropMode');
    if (cropModeBtn) {
        cropModeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            log('Crop Mode clicked');
            if (cropper) {
                cropper.setDragMode('crop');
                this.classList.add('active');
                document.getElementById('moveMode')?.classList.remove('active');
            }
        });
    }
    
    log('Toolbar controls setup completed');
}

function handleFileSelect(event) {
    log('File selected');
    const file = event.target.files[0];
    
    if (!file) {
        log('No file selected');
        return;
    }
    
    log('File details:', {
        name: file.name,
        type: file.type,
        size: file.size
    });
    
    // Validasi tipe file
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('Format file tidak valid! Gunakan JPG, PNG, atau WEBP');
        event.target.value = '';
        log('Invalid file type');
        return;
    }
    
    // Validasi ukuran file (max 5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        alert('Ukuran file terlalu besar! Maksimal 5MB');
        event.target.value = '';
        log('File size too large');
        return;
    }
    
    log('File validation passed, showing cropper modal...');
    currentFile = file;
    showCropperModal(file);
}

function showCropperModal(file) {
    log('Reading file and preparing modal...');
    const reader = new FileReader();
    
    reader.onload = function(e) {
        log('File loaded, initializing cropper...');
        const imageElement = document.getElementById('cropperImage');
        
        if (!imageElement) {
            console.error('[Banner Crop] Image element with id="cropperImage" not found!');
            return;
        }
        
        imageElement.src = e.target.result;
        
        // Destroy cropper lama jika ada
        if (cropper) {
            log('Destroying old cropper instance');
            cropper.destroy();
        }
        
        // Tampilkan modal
        log('Showing modal...');
        cropperModal.show();
        
        // Inisialisasi cropper setelah modal ditampilkan
        setTimeout(() => {
            log('Initializing new Cropper instance...');
            
            try {
                cropper = new Cropper(imageElement, {
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
                    checkOrientation: true,
                    checkCrossOrigin: true,
                    modal: true,
                    scalable: true,
                    zoomable: true,
                    zoomOnWheel: true,
                    wheelZoomRatio: 0.1,
                    movable: true,
                    rotatable: false,
                    minContainerWidth: 200,
                    minContainerHeight: 200,
                    minCropBoxWidth: 100,
                    minCropBoxHeight: 28,
                    ready: function() {
                        log('Cropper ready!');
                    }
                });
                
                log('Cropper instance created successfully');
                
                // Set default mode button as active
                const moveModeBtn = document.getElementById('moveMode');
                if (moveModeBtn) {
                    moveModeBtn.classList.add('active');
                }
                
            } catch (error) {
                console.error('[Banner Crop] Error initializing Cropper:', error);
            }
        }, 300);
    };
    
    reader.onerror = function(error) {
        console.error('[Banner Crop] Error reading file:', error);
        alert('Gagal membaca file. Silakan coba lagi.');
    };
    
    reader.readAsDataURL(file);
}

function handleCrop() {
    log('Crop button clicked');
    
    if (!cropper) {
        console.error('[Banner Crop] Cropper instance not found!');
        return;
    }
    
    // Disable tombol crop sementara
    const cropButton = document.getElementById('cropButton');
    const originalText = cropButton.innerHTML;
    cropButton.disabled = true;
    cropButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    
    log('Getting cropped canvas...');
    
    try {
        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 1440,
            height: 410,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        log('Canvas created, converting to blob...');
        
        // Convert canvas to blob
        canvas.toBlob(function(blob) {
            log('Blob created, size:', blob.size);
            
            // Create new file from blob
            const fileName = currentFile.name;
            const croppedFile = new File([blob], fileName, {
                type: currentFile.type,
                lastModified: Date.now()
            });
            
            log('New file created:', {
                name: croppedFile.name,
                type: croppedFile.type,
                size: croppedFile.size
            });
            
            // Update file input dengan file yang sudah di-crop
            updateFileInput(croppedFile);
            
            // Tampilkan preview
            showPreview(canvas.toDataURL());
            
            // Tutup modal
            cropperModal.hide();
            log('Modal hidden');
            
            // Reset tombol
            cropButton.disabled = false;
            cropButton.innerHTML = originalText;
            
            // Destroy cropper
            if (cropper) {
                cropper.destroy();
                cropper = null;
                log('Cropper destroyed');
            }
            
            log('Crop process completed successfully!');
        }, currentFile.type, 0.95);
        
    } catch (error) {
        console.error('[Banner Crop] Error during crop:', error);
        alert('Gagal melakukan crop. Silakan coba lagi.');
        
        // Reset tombol
        cropButton.disabled = false;
        cropButton.innerHTML = originalText;
    }
}

function handleCancelCrop() {
    log('Cancel button clicked');
    
    // Reset file input
    const fileInput = document.getElementById('gambar');
    fileInput.value = '';
    
    // Tutup modal
    cropperModal.hide();
    
    // Destroy cropper
    if (cropper) {
        cropper.destroy();
        cropper = null;
        log('Cropper destroyed');
    }
    
    // Sembunyikan preview
    const imagePreview = document.getElementById('imagePreview');
    if (imagePreview) {
        imagePreview.style.display = 'none';
    }
    
    log('Cancel completed');
}

function updateFileInput(file) {
    log('Updating file input with cropped file...');
    const fileInput = document.getElementById('gambar');
    
    try {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        log('File input updated successfully');
    } catch (error) {
        console.error('[Banner Crop] Error updating file input:', error);
    }
}

function showPreview(dataUrl) {
    log('Showing preview...');
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    
    if (preview && imagePreview) {
        preview.src = dataUrl;
        imagePreview.style.display = 'block';
        log('Preview displayed');
    } else {
        console.warn('[Banner Crop] Preview elements not found');
    }
}

// Cleanup saat modal ditutup
const cropperModalEl = document.getElementById('cropperModal');
if (cropperModalEl) {
    cropperModalEl.addEventListener('hidden.bs.modal', function() {
        log('Modal hidden event triggered');
        if (cropper) {
            cropper.destroy();
            cropper = null;
            log('Cropper cleaned up');
        }
    });
}

// Log saat script loaded
log('Banner Crop script loaded successfully');