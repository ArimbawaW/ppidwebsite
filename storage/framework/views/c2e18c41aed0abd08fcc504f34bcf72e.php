

<?php $__env->startSection('title', 'Struktur Organisasi - PPID'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            
            <img 
                src="<?php echo e(asset('images/struktur.png')); ?>" 
                alt="Tugas dan Fungsi PPID"
                class="img-fluid mx-auto d-block"
                style="max-width: 700px;"
            >

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/profil/struktur-organisasi.blade.php ENDPATH**/ ?>