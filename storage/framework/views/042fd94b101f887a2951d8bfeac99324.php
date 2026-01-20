<div class="mb-5">
    <div class="row g-4 justify-content-center">
        <?php
            $links = [
                ['icon' => 'informasi.png', 'title' => 'Informasi Publik', 'route' => 'informasi-publik.index'],
                ['icon' => 'permohonan.png', 'title' => 'Permohonan', 'route' => 'permohonan.index'],
                ['icon' => 'cek.png', 'title' => 'Cek Permohonan', 'route' => 'permohonan.cek-status'],
                ['icon' => 'keberatan.png', 'title' => 'Keberatan', 'route' => 'keberatan.index'],
                ['icon' => 'cek2.png', 'title' => 'Cek Keberatan', 'route' => 'keberatan.cek'],
            ];
        ?>

        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card quick-link-card shadow-sm border-0">
                    <img src="<?php echo e(asset('icons/' . $link['icon'])); ?>" alt="<?php echo e($link['title']); ?>">
                    <h5><?php echo e($link['title']); ?></h5>
                    <a href="<?php echo e(route($link['route'])); ?>" class="btn btn-quick-link">Lihat</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH C:\ppid-website\resources\views/components/quick-links.blade.php ENDPATH**/ ?>