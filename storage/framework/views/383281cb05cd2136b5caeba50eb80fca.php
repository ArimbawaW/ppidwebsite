

<?php $__env->startSection('title', 'Berita - PPID'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h2 class="mb-4">Berita & Artikel</h2>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="<?php echo e(route('berita.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="berita" <?php echo e(request('kategori') == 'berita' ? 'selected' : ''); ?>>Berita</option>
                        <option value="artikel" <?php echo e(request('kategori') == 'artikel' ? 'selected' : ''); ?>>Artikel</option>
                        <option value="pengumuman" <?php echo e(request('kategori') == 'pengumuman' ? 'selected' : ''); ?>>Pengumuman</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if($item->gambar): ?>
                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" class="card-img-top" alt="<?php echo e($item->judul); ?>" style="height: 200px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge bg-secondary mb-2"><?php echo e(ucfirst($item->kategori)); ?></span>
                    <h5 class="card-title"><?php echo e($item->judul); ?></h5>
                    <p class="card-text"><?php echo e(Str::limit(strip_tags($item->konten), 100)); ?></p>
                    <p class="card-text">
                        <small class="text-muted"><?php echo e($item->created_at->format('d M Y')); ?> | <?php echo e($item->views); ?> views</small>
                    </p>
                    <a href="<?php echo e(route('berita.show', $item->slug)); ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-md-12">
            <div class="alert alert-info">Tidak ada berita ditemukan.</div>
        </div>
        <?php endif; ?>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <?php echo e($berita->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/berita/index.blade.php ENDPATH**/ ?>