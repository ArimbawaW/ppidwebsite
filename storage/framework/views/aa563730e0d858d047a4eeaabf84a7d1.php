

<?php $__env->startSection('title', 'Edit Halaman Statis'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Halaman Statis</h2>
        <a href="<?php echo e(route('admin.halaman-statis.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?php echo e(route('admin.halaman-statis.update', $halamanStatis->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('slug', $halamanStatis->slug)); ?>" required>
                            <small class="text-muted">Contoh: informasi-berkala, informasi-setiap-saat</small>
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('judul', $halamanStatis->judul)); ?>" required>
                            <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Konten Halaman</h5>
                        <button type="button" class="btn btn-success btn-sm" onclick="addSection()">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Section
                        </button>
                    </div>

                    <div id="sectionsContainer">
                        <?php $__currentLoopData = $halamanStatis->konten; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionIndex => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="section-item card mb-3" data-index="<?php echo e($sectionIndex); ?>">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">Section <?php echo e($sectionIndex + 1); ?></h6>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Judul Section</label>
                                    <input type="text" name="sections[]" class="form-control" 
                                           value="<?php echo e($section['section']); ?>" 
                                           placeholder="Contoh: A. Informasi tentang...">
                                </div>

                                <div class="items-container">
                                    <label class="form-label fw-bold">Items:</label>
                                    <?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemIndex => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="item-row mb-2">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="text" 
                                                       name="items[<?php echo e($sectionIndex); ?>][]" 
                                                       class="form-control" 
                                                       value="<?php echo e($item['text']); ?>"
                                                       placeholder="Nama item">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="url" 
                                                       name="file_urls[<?php echo e($sectionIndex); ?>][]" 
                                                       class="form-control" 
                                                       value="<?php echo e($item['file_url'] ?? ''); ?>"
                                                       placeholder="URL file (opsional)">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeItem(this)">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addItem(this)">
                                    <i class="bi bi-plus me-1"></i>Tambah Item
                                </button>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                               value="1" <?php echo e(old('is_active', $halamanStatis->is_active) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Update
                    </button>
                    <a href="<?php echo e(route('admin.halaman-statis.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let sectionCounter = <?php echo e(count($halamanStatis->konten)); ?>;

function addSection() {
    const container = document.getElementById('sectionsContainer');
    const sectionHTML = `
        <div class="section-item card mb-3" data-index="${sectionCounter}">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Section ${sectionCounter + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Judul Section</label>
                    <input type="text" name="sections[]" class="form-control" placeholder="Contoh: A. Informasi tentang...">
                </div>

                <div class="items-container">
                    <label class="form-label fw-bold">Items:</label>
                    <div class="item-row mb-2">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="items[${sectionCounter}][]" class="form-control" placeholder="Nama item">
                            </div>
                            <div class="col-md-5">
                                <input type="url" name="file_urls[${sectionCounter}][]" class="form-control" placeholder="URL file (opsional)">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeItem(this)">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addItem(this)">
                    <i class="bi bi-plus me-1"></i>Tambah Item
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', sectionHTML);
    sectionCounter++;
}

function removeSection(button) {
    if (confirm('Yakin ingin menghapus section ini?')) {
        button.closest('.section-item').remove();
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
                    <input type="text" name="items[${sectionIndex}][]" class="form-control" placeholder="Nama item">
                </div>
                <div class="col-md-5">
                    <input type="url" name="file_urls[${sectionIndex}][]" class="form-control" placeholder="URL file (opsional)">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeItem(this)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
}

function removeItem(button) {
    button.closest('.item-row').remove();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/halaman-statis/edit.blade.php ENDPATH**/ ?>