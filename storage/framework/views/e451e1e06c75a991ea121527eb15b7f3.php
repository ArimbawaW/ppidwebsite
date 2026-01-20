

<?php $__env->startSection('title', 'Galeri - PPID'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h2 class="mb-4 text-center fw-bold">GALERI KEGIATAN</h2>
    
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $galeri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 col-lg-3">
            <a href="<?php echo e(asset('storage/' . $item->gambar)); ?>" 
               class="glightbox" 
               data-gallery="gallery1"
               data-glightbox="title: <?php echo e($item->judul); ?>; description: <?php echo e($item->deskripsi ?? ''); ?>">
                <div class="galeri-item">
                    <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" 
                         alt="<?php echo e($item->judul); ?>"
                         class="img-fluid">
                    <div class="galeri-overlay">
                        <h6 class="mb-1"><?php echo e($item->judul); ?></h6>
                        <?php if($item->deskripsi): ?>
                        <small><?php echo e(Str::limit($item->deskripsi, 50)); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-md-12">
            <div class="alert alert-info text-center">Tidak ada galeri ditemukan.</div>
        </div>
        <?php endif; ?>
    </div>

    <?php if($galeri->hasPages()): ?>
    <div class="row mt-5">
        <div class="col-md-12 d-flex justify-content-center">
            <?php echo e($galeri->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/galeri/index.blade.php ENDPATH**/ ?>