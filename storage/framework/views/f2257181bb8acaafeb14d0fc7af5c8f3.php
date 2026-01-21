

<?php $__env->startSection('title', 'Cek Status Permohonan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-search fa-3x text-primary mb-3"></i>
                        <h3 class="fw-bold" style="color:#0e5b73;">Cek Status Permohonan</h3>
                        <p class="text-muted">Masukkan nomor registrasi Anda untuk mengecek status permohonan informasi</p>
                    </div>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('permohonan.cek-status.proses')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-hashtag"></i> Nomor Registrasi
                            </label>
                            <input type="text" 
                                   name="nomor_registrasi" 
                                   class="form-control form-control-lg <?php $__errorArgs = ['nomor_registrasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="Contoh: PPID/PERMOHONAN/2025/12/001"
                                   value="<?php echo e(old('nomor_registrasi')); ?>"
                                   required>
                            <?php $__errorArgs = ['nomor_registrasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Masukkan nomor registrasi yang Anda terima saat mengajukan permohonan
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background:#0e5b73;color:white;">
                                <i class="fas fa-search"></i> Cek Status
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">
                            Belum mengajukan permohonan? 
                            <a href="<?php echo e(route('permohonan.index')); ?>" class="text-decoration-none fw-bold" style="color:#0e5b73;">
                                Ajukan Sekarang
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\ppidwebsite\resources\views/frontend/permohonan/cek-status.blade.php ENDPATH**/ ?>