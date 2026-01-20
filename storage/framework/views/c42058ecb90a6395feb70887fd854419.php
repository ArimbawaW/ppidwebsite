

<?php $__env->startSection('title', $berita->judul . ' - PPID'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* === PERAPIAN TAMPILAN BERITA === */
    .content {
        font-size: 17px;
        line-height: 1.8;
        text-align: justify;
        color: #333;
        white-space: normal; /* supaya teks panjang tidak numpuk */
        word-break: break-word; /* antisipasi kata nyambung tanpa spasi */
    }

    .content p {
        margin-bottom: 1.2rem;
    }

    .content img {
        max-width: 100%;
        height: auto;
        margin: 15px 0;
        border-radius: 6px;
        display: block;
    }

    .content br {
        margin-bottom: 10px;
    }

    .content h1, 
    .content h2, 
    .content h3, 
    .content h4 {
        margin-top: 25px;
        margin-bottom: 15px;
        font-weight: 600;
        line-height: 1.3;
    }

    .content ul, 
    .content ol {
        padding-left: 20px;
        margin-bottom: 1.2rem;
    }

    /* Supaya tulisan tidak berdempetan jika admin tidak pakai <p> */
    .content * + * {
        margin-top: 10px;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <article>
                <h1><?php echo e($berita->judul); ?></h1>
                <p class="text-muted">
                    <span class="badge bg-secondary"><?php echo e($berita->kategori_label); ?></span>
                    <span class="ms-2"><?php echo e($berita->created_at->format('d M Y')); ?></span>
                    <span class="ms-2">| <?php echo e($berita->views); ?> views</span>
                </p>

                <?php if($berita->gambar): ?>
                <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" class="img-fluid mb-3" alt="<?php echo e($berita->judul); ?>">
                <?php endif; ?>

                <div class="content">
                    <?php echo $berita->konten; ?>

                </div>
            </article>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Berita Terbaru</h5>
                </div>
                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = $beritaTerbaru->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('berita.show', $item->slug)); ?>" class="list-group-item list-group-item-action">
                        <h6 class="mb-1"><?php echo e($item->judul); ?></h6>
                        <small class="text-muted"><?php echo e($item->created_at->format('d M Y')); ?></small>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/berita/show.blade.php ENDPATH**/ ?>