

<?php $__env->startSection('title', 'Tambah Halaman Standar Layanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Halaman Baru</h1>
        <a href="<?php echo e(route('admin.standar-layanan.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.standar-layanan.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Halaman yang Anda buat akan otomatis muncul di dropdown menu <strong>"Standar Layanan"</strong>
                </div>

                <div class="row">
                    <!-- Nama Layanan (Judul Halaman) -->
                    <div class="col-md-8 mb-3">
                        <label for="nama_layanan" class="form-label fw-bold">
                            Nama Layanan (Judul Halaman) <span class="text-danger">*</span>
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
                               value="<?php echo e(old('nama_layanan')); ?>" 
                               placeholder="Contoh: Permohonan Informasi Publik" required>
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
                               value="<?php echo e(old('urutan', 0)); ?>" 
                               min="0">
                        <small class="text-muted">Semakin kecil tampil lebih dulu</small>
                    </div>

                    <!-- Gambar/Banner -->
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label fw-bold">Gambar/Banner Halaman</label>
                        <input type="file" name="gambar" id="gambar" 
                               class="form-control <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               accept="image/*">
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        <!-- Preview -->
                        <div id="preview" class="mt-2" style="display:none;">
                            <img id="previewImg" src="" style="max-width: 300px;" class="img-thumbnail">
                        </div>
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2" 
                                  class="form-control" 
                                  placeholder="Deskripsi singkat untuk preview"><?php echo e(old('deskripsi')); ?></textarea>
                    </div>

                    <!-- Konten Halaman -->
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
                                  placeholder="Tulis konten halaman di sini..." required><?php echo e(old('konten')); ?></textarea>
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

                    <!-- Upload File Pendukung (Opsional) -->
                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label fw-bold">File Pendukung (Opsional)</label>
                        <input type="file" name="file" id="file" 
                               class="form-control" 
                               accept=".pdf,.doc,.docx">
                        <small class="text-muted">File tambahan yang bisa didownload (PDF, DOC, DOCX - Max: 10MB)</small>
                    </div>

                    <!-- Status Aktif -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Halaman
                            </label>
                            <div class="text-muted small mt-1">
                                Jika dicentang, halaman akan muncul di dropdown menu
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?php echo e(route('admin.standar-layanan.index')); ?>" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Halaman
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/standar-layanan/create.blade.php ENDPATH**/ ?>