

<?php $__env->startSection('title', $layanan->nama_layanan . ' - PPID'); ?>

<?php $__env->startSection('content'); ?>

<!-- ================= HEADER ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
    <div class="container">
        <h1 class="text-white fw-bold mb-2">
            <?php echo e($layanan->nama_layanan); ?>

        </h1>

        <?php if($layanan->deskripsi): ?>
            <p class="text-white-50 mb-0">
                <?php echo e($layanan->deskripsi); ?>

            </p>
        <?php endif; ?>
    </div>
</section>
<!-- ========================================= -->

<!-- ================= KONTEN ================= -->
<section class="py-4">
    <div class="container">

        <!-- ===== TEKS ===== -->
        <div class="content-area mb-4" style="font-size: 16px; line-height: 1.8;">
            <?php echo nl2br(e($layanan->konten)); ?>

        </div>

        <!-- ===== GAMBAR INFOGRAFIS ===== -->
        <?php if($layanan->gambar): ?>
        <div class="infografis-wrapper">
            <img 
                src="<?php echo e(asset('storage/' . $layanan->gambar)); ?>" 
                alt="<?php echo e($layanan->nama_layanan); ?>" 
                class="infografis-image">
        </div>
        <?php endif; ?>

        <!-- ===== FILE ===== -->
        <?php if($layanan->file): ?>
        <div class="mt-3">
            <a href="<?php echo e(asset('storage/' . $layanan->file)); ?>" 
               target="_blank" 
               class="btn btn-primary">
                <i class="bi bi-download me-2"></i>
                Unduh Dokumen Pendukung
            </a>
        </div>
        <?php endif; ?>

    </div>
</section>
<!-- ========================================= -->

<!-- ================= CSS ================= -->
<style>
/* Wrapper infografis */
.infografis-wrapper {
    width: 100%;
    max-width: 1200px;   /* mirip contoh Kemenkeu */
    margin: 0 auto 1.5rem;
    text-align: center;
}

/* Gambar besar, proporsional, tanpa crop */
.infografis-image {
    width: 100%;
    height: auto;
    max-height: none;

    display: block;
    margin: 0 auto;

    object-fit: contain;
}

/* Mobile */
@media (max-width: 768px) {
    .infografis-wrapper {
        max-width: 100%;
    }
}
</style>
<!-- ========================================= -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/standar-layanan/show.blade.php ENDPATH**/ ?>