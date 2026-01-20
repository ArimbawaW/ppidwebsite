

<?php $__env->startSection('title', 'Tambah Halaman Statis'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .section-item {
        border-left: 4px solid #3b82f6;
    }
    
    .item-row {
        background: #f8fafc;
        padding: 10px;
        border-radius: 6px;
    }
    
    .btn-add-section {
        transition: all 0.3s;
    }
    
    .btn-add-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Halaman Statis</h2>
            <p class="text-muted mb-0">Buat halaman template baru seperti Informasi Berkala, Informasi Setiap Saat, dll</p>
        </div>
        <a href="<?php echo e(route('admin.halaman-statis.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?php echo e(route('admin.halaman-statis.store')); ?>" method="POST" id="formHalaman">
                <?php echo csrf_field(); ?>

                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Petunjuk:</strong> Isi informasi dasar halaman, lalu tambahkan section (A, B, C...) dan items di dalamnya.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Slug <span class="text-danger">*</span>
                                <i class="bi bi-question-circle" data-bs-toggle="tooltip" title="URL halaman, contoh: informasi-berkala"></i>
                            </label>
                            <input type="text" 
                                   name="slug" 
                                   class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('slug')); ?>" 
                                   placeholder="informasi-berkala"
                                   required>
                            <small class="text-muted">Akan menjadi URL: /halaman/<strong>informasi-berkala</strong></small>
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Judul Halaman <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('judul')); ?>" 
                                   placeholder="Informasi Publik yang Wajib Disediakan..."
                                   required>
                            <small class="text-muted">Akan tampil sebagai judul utama halaman</small>
                            <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Konten Halaman</h5>
                            <small class="text-muted">Tambahkan section (A, B, C...) dan items di dalamnya</small>
                        </div>
                        <button type="button" class="btn btn-success btn-add-section" onclick="addSection()">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Section
                        </button>
                    </div>

                    <div id="sectionsContainer">
                        
                    </div>

                    <div class="alert alert-warning mt-3" id="emptyWarning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Belum ada section. Klik tombol <strong>"Tambah Section"</strong> untuk mulai.
                    </div>
                </div>

                <hr class="my-4">

                
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" 
                               name="is_active" 
                               class="form-check-input" 
                               id="is_active" 
                               value="1" 
                               <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                        <label class="form-check-label fw-bold" for="is_active">
                            Aktifkan Halaman
                            <small class="text-muted d-block">Jika tidak dicentang, halaman tidak akan bisa diakses publik</small>
                        </label>
                    </div>
                </div>

                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Simpan Halaman
                    </button>
                    <a href="<?php echo e(route('admin.halaman-statis.index')); ?>" class="btn btn-secondary btn-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let sectionCounter = 0;

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function addSection() {
    const container = document.getElementById('sectionsContainer');
    const emptyWarning = document.getElementById('emptyWarning');
    
    // Sembunyikan warning kosong
    if (emptyWarning) {
        emptyWarning.style.display = 'none';
    }
    
    const sectionHTML = `
        <div class="section-item card mb-3" data-index="${sectionCounter}">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-folder-fill me-2 text-primary"></i>
                            Section ${sectionCounter + 1}
                        </h6>
                        <small class="text-muted">Contoh: A. Informasi tentang...</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">
                        <i class="bi bi-trash"></i> Hapus Section
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Judul Section <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="sections[]" 
                           class="form-control" 
                           placeholder="Contoh: A. Informasi tentang Kementerian Perumahan dan Kawasan Permukiman"
                           required>
                </div>

                <div class="items-container">
                    <label class="form-label fw-bold">
                        <i class="bi bi-list-ol me-1"></i>Items dalam Section:
                    </label>
                    
                    
                    <div class="item-row mb-2">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" 
                                       name="items[${sectionCounter}][]" 
                                       class="form-control" 
                                       placeholder="Nama item (contoh: Alamat Lengkap)"
                                       required>
                            </div>
                            <div class="col-md-5">
                                <input type="url" 
                                       name="file_urls[${sectionCounter}][]" 
                                       class="form-control" 
                                       placeholder="https://example.com/file.pdf (opsional)">
                            </div>
                            <div class="col-md-1">
                                <button type="button" 
                                        class="btn btn-sm btn-danger w-100" 
                                        onclick="removeItem(this)"
                                        title="Hapus item">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" 
                        class="btn btn-sm btn-outline-primary mt-2" 
                        onclick="addItem(this)">
                    <i class="bi bi-plus me-1"></i>Tambah Item
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHTML);
    sectionCounter++;
}

function removeSection(button) {
    if (confirm('Yakin ingin menghapus section ini beserta semua items di dalamnya?')) {
        button.closest('.section-item').remove();
        
        // Tampilkan warning jika tidak ada section
        const container = document.getElementById('sectionsContainer');
        const emptyWarning = document.getElementById('emptyWarning');
        if (container.children.length === 0 && emptyWarning) {
            emptyWarning.style.display = 'block';
        }
    }
}

function addItem(button) {
    const sectionItem = button.closest('.section-item');
    const sectionIndex = sectionItem.dataset.index;
    const itemsContainer = sectionItem.querySelector('.items-container');
    
    const itemHTML = `
        <div class="item-row mb-2">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" 
                           name="items[${sectionIndex}][]" 
                           class="form-control" 
                           placeholder="Nama item"
                           required>
                </div>
                <div class="col-md-5">
                    <input type="url" 
                           name="file_urls[${sectionIndex}][]" 
                           class="form-control" 
                           placeholder="URL file (opsional)">
                </div>
                <div class="col-md-1">
                    <button type="button" 
                            class="btn btn-sm btn-danger w-100" 
                            onclick="removeItem(this)"
                            title="Hapus item">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
}

function removeItem(button) {
    const itemsContainer = button.closest('.items-container');
    const itemCount = itemsContainer.querySelectorAll('.item-row').length;
    
    // Minimal harus ada 1 item per section
    if (itemCount <= 1) {
        alert('Setiap section harus memiliki minimal 1 item');
        return;
    }
    
    button.closest('.item-row').remove();
}

// Validasi sebelum submit
document.getElementById('formHalaman').addEventListener('submit', function(e) {
    const container = document.getElementById('sectionsContainer');
    
    if (container.children.length === 0) {
        e.preventDefault();
        alert('Anda harus menambahkan minimal 1 section dengan items!');
        return false;
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/halaman-statis/create.blade.php ENDPATH**/ ?>