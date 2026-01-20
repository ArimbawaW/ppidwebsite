

<?php $__env->startSection('title', 'Cek Status Keberatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h2 class="mb-4">Cek Status Keberatan</h2>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('keberatan.cek.proses')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="nomor_registrasi" class="form-label">Nomor Registrasi Keberatan</label>
                    <input type="text" name="nomor_registrasi" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Cek Status</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/keberatan/cek.blade.php ENDPATH**/ ?>