

<?php $__env->startSection('title', 'Regulasi - PPID'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-3">Regulasi</h1>
                <p class="text-white-50 mb-0 fs-5">
                    Kumpulan peraturan perundang-undangan yang menjadi dasar pelaksanaan PPID
                </p>
            </div>
            <div class="col-md-4 text-end">
                <i class="bi bi-file-earmark-text text-white" style="font-size: 120px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active">Semua</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $regulasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <!-- Badge Kategori -->
                        <div class="mb-3">
                            <span class="badge bg-primary"><?php echo e($item->kategori ?? 'Regulasi'); ?></span>
                            <?php if($item->tanggal_terbit): ?>
                            <span class="badge bg-secondary"><?php echo e($item->tanggal_terbit->format('Y')); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Nomor -->
                        <?php if($item->nomor): ?>
                        <h6 class="text-muted mb-2"><?php echo e($item->nomor); ?></h6>
                        <?php endif; ?>

                        <!-- Judul -->
                        <h5 class="card-title fw-bold mb-3" style="color: #1a6b8a;">
                            <?php echo e($item->judul); ?>

                        </h5>

                        <!-- Deskripsi -->
                        <?php if($item->deskripsi): ?>
                        <p class="card-text text-muted small">
                            <?php echo e(Str::limit($item->deskripsi, 100)); ?>

                        </p>
                        <?php endif; ?>

                        <!-- Tanggal -->
                        <?php if($item->tanggal_terbit): ?>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            Ditetapkan: <?php echo e($item->tanggal_terbit->format('d F Y')); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer bg-white border-0">
                        <?php if($item->file): ?>
                        <a href="<?php echo e(asset('storage/' . $item->file)); ?>" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-download me-2"></i>Unduh Dokumen
                        </a>
                        <?php else: ?>
                        <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                            <i class="bi bi-file-earmark-x me-2"></i>Dokumen Tidak Tersedia
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada regulasi yang tersedia.
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($regulasi->hasPages()): ?>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <?php echo e($regulasi->links()); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid\resources\views/frontend/regulasi/index.blade.php ENDPATH**/ ?>