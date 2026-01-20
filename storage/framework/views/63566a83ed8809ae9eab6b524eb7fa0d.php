

<?php $__env->startSection('title', $halaman->judul); ?>

<?php
    use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startPush('styles'); ?>
<style>
    /* HEADER - Warna Putih/Abu */
    .header-section {
        background: #ffffff;  /* Putih */
        /* Atau pakai abu-abu: background: #f8f9fa; */
        padding: 60px 0;
        border-bottom: 3px solid #e5e7eb;  /* Border bawah */
    }

    /* LOGO - Diperbesar */
    .logo-section {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo-section img {
        max-width: 300px;  /* Diperbesar dari 200px jadi 300px */
        height: auto;
        /* Kalau mau lebih besar lagi, ubah jadi 400px atau 500px */
    }

    /* JUDUL - Warna Gelap */
    .page-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 0;
        color: #1f2937;  /* Abu gelap, bukan putih */
    }

    /* KONTEN */
    .content-section {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    /* SECTION HEADER - Warna Netral */
    .section-header {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 40px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #6b7280;  /* Abu, bukan biru */
    }

    .section-header:first-of-type {
        margin-top: 0;
    }

    /* LIST ITEMS - Warna Netral */
    .item-list {
        list-style: none;
        padding: 0;
        margin: 0;
        counter-reset: item-counter;
    }

    .item-list li {
        counter-increment: item-counter;
        padding: 15px 20px;
        margin-bottom: 10px;
        background: #f8fafc;
        border-radius: 8px;
        border-left: 4px solid #6b7280;  /* Abu, bukan biru */
        transition: all 0.3s;
        position: relative;
    }

    .item-list li:hover {
        background: #f3f4f6;  /* Abu muda, bukan biru */
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(107, 114, 128, 0.2);  /* Shadow abu */
    }

    .item-list li:before {
        content: counter(item-counter) ". ";
        font-weight: 700;
        color: #374151;  /* Abu gelap, bukan biru */
        margin-right: 8px;
    }

    .item-list li a {
        color: #1e293b;
        text-decoration: none;
        font-weight: 500;
    }

    .item-list li a:hover {
        color: #374151;  /* Abu gelap, bukan biru */
    }

    .item-list li.no-link {
        cursor: default;
    }

    .item-list li.no-link:hover {
        transform: none;
        background: #f8fafc;
    }

    /* ICON FILE - Warna Netral */
    .icon-file {
        color: #6b7280;  /* Abu, bukan biru */
        margin-right: 8px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="header-section">
    <div class="container">
        <div class="logo-section">
            <img src="<?php echo e(asset('images/logo-kemenpkp.png')); ?>" alt="Logo Kemen PKP">
        </div>
        <h1 class="page-title"><?php echo e($halaman->judul); ?></h1>
    </div>
</div>

<div class="container mb-5">
    <div class="content-section">
        
        <?php $__currentLoopData = $halaman->konten; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h2 class="section-header"><?php echo e($section['section']); ?></h2>
            
            <ol class="item-list">
                <?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fileLink = !empty($item['file_path'])
                            ? Storage::url($item['file_path'])
                            : ($item['file_url'] ?? null);
                    ?>
                    <li class="<?php echo e($fileLink ? '' : 'no-link'); ?>">
                        <?php if($fileLink): ?>
                            <a href="<?php echo e($fileLink); ?>" target="_blank" rel="noopener">
                                <i class="bi bi-file-earmark-pdf icon-file"></i>
                                <?php echo e($item['text']); ?>

                            </a>
                        <?php else: ?>
                            <i class="bi bi-file-earmark icon-file"></i>
                            <?php echo e($item['text']); ?>

                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\ppidwebsite\resources\views/frontend/halaman-statis/show.blade.php ENDPATH**/ ?>