<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard - PPID'); ?></title>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-theme.css')); ?>">

    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        
        <nav class="navbar navbar-dark d-md-none" style="background-color:#003f54;">
            <div class="container-fluid">
                <span class="navbar-brand">Admin Panel</span>
                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        
        <nav id="sidebarMenu"
             class="col-md-3 col-lg-2 d-md-block sidebar collapse">

            
            <div class="logo-area">
                <img src="<?php echo e(asset('images/logoppid.png')); ?>" alt="Logo PPID">
            </div>

            <div class="menu-title">Menu Utama</div>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.permohonan.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.permohonan.index')); ?>">
                        <i class="bi bi-envelope"></i> Permohonan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.keberatan.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.keberatan.index')); ?>">
                        <i class="bi bi-exclamation-circle"></i> Keberatan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.berita.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.berita.index')); ?>">
                        <i class="bi bi-newspaper"></i> Berita
                    </a>
                </li>

                

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.halaman-statis.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.halaman-statis.index')); ?>">
                        <i class="bi bi-file-earmark-text"></i> Halaman Statis
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.agenda-kegiatan.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.agenda-kegiatan.index')); ?>">
                        <i class="bi bi-calendar-event"></i> Agenda Kegiatan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.galeri.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.galeri.index')); ?>">
                        <i class="bi bi-images"></i> Galeri
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.regulasi.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.regulasi.index')); ?>">
                        <i class="bi bi-book"></i> Regulasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.standar-layanan.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.standar-layanan.index')); ?>">
                        <i class="bi bi-clipboard-check"></i> Standar Layanan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.faq.*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.faq.index')); ?>">
                        <i class="bi bi-question-circle"></i> FAQ
                    </a>
                </li>

                <div class="menu-title mt-3">Lainnya</div>

                <li class="nav-item">
                    <a class="nav-link homepage-link"
                       href="<?php echo e(route('home')); ?>"
                       target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat Website
                    </a>
                </li>

                <li class="nav-item">
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="nav-link text-start w-100 border-0 bg-transparent">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </nav>

        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\ppid-website\ppidwebsite\resources\views/layouts/admin.blade.php ENDPATH**/ ?>