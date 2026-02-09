

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
        <form action="<?php echo e(route('regulasi.index')); ?>" method="GET">
            <div class="row g-3 align-items-end">
                <!-- Search Box -->
                <div class="col-md-4">
                    <label class="form-label fw-bold small">
                        <i class="bi bi-search me-1"></i>Cari Regulasi
                    </label>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari judul, nomor, atau deskripsi..."
                           value="<?php echo e(request('search')); ?>">
                </div>

                <!-- Filter Kategori -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small">
                        <i class="bi bi-funnel me-1"></i>Kategori
                    </label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = ['Undang-Undang','Peraturan Pemerintah','Peraturan Menteri','Peraturan Daerah','Peraturan Presiden','Surat Edaran','Keputusan','Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kat); ?>" <?php echo e(request('kategori') == $kat ? 'selected' : ''); ?>>
                                <?php echo e($kat); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="col-md-2">
                    <label class="form-label fw-bold small">
                        <i class="bi bi-calendar3 me-1"></i>Tahun
                    </label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php if(isset($tahuns)): ?>
                            <?php $__currentLoopData = $tahuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tahun); ?>" <?php echo e(request('tahun') == $tahun ? 'selected' : ''); ?>>
                                    <?php echo e($tahun); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                        <a href="<?php echo e(route('regulasi.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Search Results Info -->
        <?php if(request()->hasAny(['search', 'kategori', 'tahun'])): ?>
        <div class="mt-3">
            <div class="alert alert-info mb-0 d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Hasil Pencarian:</strong> 
                    Ditemukan <?php echo e($regulasi->total()); ?> regulasi
                    <?php if(request('search')): ?>
                        untuk "<strong><?php echo e(request('search')); ?></strong>"
                    <?php endif; ?>
                    <?php if(request('kategori')): ?>
                        dalam kategori <strong><?php echo e(request('kategori')); ?></strong>
                    <?php endif; ?>
                    <?php if(request('tahun')): ?>
                        tahun <strong><?php echo e(request('tahun')); ?></strong>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e(route('regulasi.index')); ?>" class="btn btn-sm btn-outline-info">
                    Lihat Semua
                </a>
            </div>
        </div>
        <?php endif; ?>
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
                        <h5 class="card-title fw-bold mb-3 title-clamp"
    title="<?php echo e($item->judul); ?>">
    <?php if(request('search')): ?>
        <?php echo Str::limit(
            str_ireplace(
                request('search'),
                '<mark>' . request('search') . '</mark>',
                $item->judul
            ),
            150
        ); ?>

    <?php else: ?>
        <?php echo e(Str::limit($item->judul, 150)); ?>

    <?php endif; ?>
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
                            <i class="bi bi-download me-2"></i>Baca online
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
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-search fs-1 d-block mb-3 text-muted"></i>
                    <h5 class="mb-2">Tidak Ada Hasil</h5>
                    <p class="mb-3">
                        <?php if(request()->hasAny(['search', 'kategori', 'tahun'])): ?>
                            Tidak ditemukan regulasi yang sesuai dengan pencarian Anda.
                        <?php else: ?>
                            Belum ada regulasi yang tersedia.
                        <?php endif; ?>
                    </p>
                    <?php if(request()->hasAny(['search', 'kategori', 'tahun'])): ?>
                    <a href="<?php echo e(route('regulasi.index')); ?>" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Pencarian
                    </a>
                    <?php endif; ?>
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

/* Highlight search results */
mark {
    background-color: #ffd700;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
}
.title-clamp {
    color: #1a6b8a;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid\resources\views/frontend/regulasi/index.blade.php ENDPATH**/ ?>