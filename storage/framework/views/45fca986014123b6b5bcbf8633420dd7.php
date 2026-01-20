

<?php $__env->startSection('title', 'Edit Halaman Standar Layanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Halaman</h1>
        <a href="<?php echo e(route('admin.standar-layanan.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.standar-layanan.update', $standarLayanan)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <!-- Nama Layanan -->
                    <div class="col-md-8 mb-3">
                        <label for="nama_layanan" class="form-label fw-bold">
                            Nama Layanan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_layanan" id="nama_layanan" 
                               class="form-control <?php $__errorArgs = ['nama_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('nama_layanan', $standarLayanan->nama_layanan)); ?>" required>
                        <?php $__errorArgs = ['nama_layanan'];
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

                    <!-- Urutan -->
                    <div class="col-md-4 mb-3">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" name="urutan" id="urutan" 
                               class="form-control" 
                               value="<?php echo e(old('urutan', $standarLayanan->urutan)); ?>" 
                               min="0">
                    </div>

                    <!-- Gambar -->
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label fw-bold">Gambar/Banner</label>
                        
                        <?php if($standarLayanan->gambar): ?>
                        <div class="mb-2">
                            <img src="<?php echo e(asset('storage/' . $standarLayanan->gambar)); ?>" 
                                 style="max-width: 300px;" class="img-thumbnail">
                        </div>
                        <?php endif; ?>
                        
                        <input type="file" name="gambar" id="gambar" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Upload gambar baru jika ingin mengganti</small>
                        
                        <!-- Preview -->
                        <div id="preview" class="mt-2" style="display:none;">
                            <img id="previewImg" src="" style="max-width: 300px;" class="img-thumbnail">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2" 
                                  class="form-control"><?php echo e(old('deskripsi', $standarLayanan->deskripsi)); ?></textarea>
                    </div>

                    <!-- Konten -->
                    <div class="col-md-12 mb-3">
                        <label for="konten" class="form-label fw-bold">
                            Konten Halaman <span class="text-danger">*</span>
                        </label>
                        <textarea name="konten" id="konten" rows="15" 
                                  class="form-control <?php $__errorArgs = ['konten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  required><?php echo e(old('konten', $standarLayanan->konten)); ?></textarea>
                        <?php $__errorArgs = ['konten'];
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

                    <!-- File -->
                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label fw-bold">File Pendukung</label>
                        
                        <?php if($standarLayanan->file): ?>
                        <div class="mb-2">
                            <a href="<?php echo e(asset('storage/' . $standarLayanan->file)); ?>" target="_blank" class="btn btn-sm btn-info">
                                <i class="bi bi-file-earmark"></i> Lihat File Saat Ini
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <input type="file" name="file" id="file" 
                               class="form-control" 
                               accept=".pdf,.doc,.docx">
                        <small class="text-muted">Upload file baru jika ingin mengganti</small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                   value="1" <?php echo e(old('is_active', $standarLayanan->is_active) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Halaman
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?php echo e(route('admin.standar-layanan.index')); ?>" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Halaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Preview gambar
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/standar-layanan/edit.blade.php ENDPATH**/ ?>