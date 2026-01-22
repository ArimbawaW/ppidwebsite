<?php if($beritaTerbaru->count() > 0): ?>
<div class="my-5 pt-4">
    <h3 class="fw-bold mb-4 news-section-title">Berita Terbaru</h3>
    <div class="row g-4">
        <?php $__currentLoopData = $beritaTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4">
            <div class="card news-card h-100 border-0 shadow-sm">
                <?php if($berita->gambar): ?>
                <div class="news-image-wrapper position-relative">
                    <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>"
                         class="card-img-top"
                         alt="<?php echo e($berita->judul); ?>">
                    
                    <!-- Views Badge di pojok kanan bawah -->
                    <div class="position-absolute bottom-0 end-0 m-2">
                        <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2">
                            <i class="bi bi-eye"></i> <?php echo e(number_format($berita->views)); ?>

                        </span>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="fw-bold news-title"><?php echo e($berita->judul); ?></h5>
                    
                    <!-- Tanggal di bawah judul -->
                    <p class="text-muted small mb-3">
                        <i class="bi bi-calendar3"></i> 
                        <?php echo e(\Carbon\Carbon::parse($berita->created_at)->locale('id')->isoFormat('D MMMM YYYY')); ?>

                    </p>
                    
                    <a href="<?php echo e(route('berita.show', $berita->slug)); ?>"
                       class="btn btn-sm btn-news">
                       Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<style>
    .news-image-wrapper {
        overflow: hidden;
    }
    
    .news-card:hover .card-img-top {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    
    .card-img-top {
        transition: transform 0.3s ease;
    }
</style>
<?php endif; ?><?php /**PATH C:\ppid\resources\views/components/news-section.blade.php ENDPATH**/ ?>