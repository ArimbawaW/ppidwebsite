

<?php $__env->startSection('title', 'Beranda - PPID'); ?>

<?php $__env->startPush('styles'); ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/home/base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/hero.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/quick-links.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/agenda.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/news.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/ppid.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/stats.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/gallery.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/aplikasi-terkait.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/statistics.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="container my-5">
        <?php echo $__env->make('components.welcome-banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.quick-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.agenda-section', ['agendaKegiatan' => $agendaKegiatan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.news-section', ['beritaTerbaru' => $beritaTerbaru], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <?php echo $__env->make('components.ppid-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    
    <?php echo $__env->make('components.statistics-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo $__env->make('components.gallery-section', ['galeriTerbaru' => $galeriTerbaru], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    
    <?php echo $__env->make('components.aplikasi-terkait', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
    <script src="<?php echo e(asset('js/home/carousel.js')); ?>"></script>
    <script src="<?php echo e(asset('js/home/gallery.js')); ?>"></script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
    <script src="<?php echo e(asset('js/home/statistics.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid\resources\views/frontend/home.blade.php ENDPATH**/ ?>