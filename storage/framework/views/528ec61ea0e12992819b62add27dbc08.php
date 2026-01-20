<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'PPID Website'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/LogoPKP.png')); ?>">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        /* ==== STICKY FOOTER ==== */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }
        /* ==== END STICKY FOOTER ==== */

        body, * {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600;
        }

        .navbar-brand {
            font-weight: 800 !important;
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        /* Agar navbar menempel kiri */
        .navbar {
            padding-left: 0 !important;
            padding-right: 0 !important;
            position: relative;
        }

        .navbar .container-fluid {
            padding-left: 0 !important;
            padding-right: 20px !important;
        }

        .navbar::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #d5c58a;
        }

        footer {
            position: relative;
        }

        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #d5c58a;
        }

        /* === PERGESERAN LOGO SEDIKIT KE KANAN === */
        .navbar-brand img {
            margin-left: 8px !important;
        }

        /* === GALERI LIGHTBOX STYLE === */
        .galeri-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .galeri-item:hover {
            transform: scale(1.05);
        }

        .galeri-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .galeri-item:hover img {
            transform: scale(1.1);
        }

        .galeri-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            padding: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .galeri-item:hover .galeri-overlay {
            opacity: 1;
        }

        /* Custom GLightbox styling */
        .glightbox-clean .gslide-description {
            background: rgba(0, 0, 0, 0.75);
            padding: 15px 20px;
        }

        /* Navbar active state */
        .nav-link.active {
            color: #d5c58a !important;
        }

        .ppid-link,
        .ppid-link:hover,
        .ppid-link:focus,
        .ppid-link:active {
            text-decoration: none !important;
            color: inherit !important;
        }

        /* =========================================================
           FIX TOMBOL NAVBAR MENU SELALU DI KANAN (MOBILE)
           ========================================================= */
        
        /* Desktop - tetap seperti semula */
        @media (min-width: 992px) {
            .navbar-toggler {
                display: none;
            }
        }

        /* Mobile - tombol navbar di kanan */
        @media (max-width: 991.98px) {
            /* Pastikan container-fluid menggunakan flexbox */
            .navbar .container-fluid {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-left: 0 !important;
                padding-right: 12px !important;
            }

            /* Logo tetap di kiri */
            .navbar-brand {
                order: 1;
                flex-shrink: 0;
            }

            /* Tombol toggler di kanan */
            .navbar-toggler {
                order: 3;
                margin-left: auto;
                border: 2px solid rgba(255, 255, 255, 0.5) !important;
                padding: 6px 10px;
            }

            /* Menu collapse di bawah */
            .navbar-collapse {
                order: 4;
                width: 100%;
                flex-basis: 100%;
            }

            /* Padding untuk menu items */
            .navbar-nav {
                margin-top: 12px;
            }

            .navbar-nav .nav-item {
                margin-bottom: 6px;
            }

            .navbar-nav .nav-link {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            /* Dropdown menu */
            .dropdown-menu {
                margin-left: 12px;
                margin-right: 12px;
            }
        }

        /* Logo Desktop */
        .footer-logo-desktop {
            height: 70px;
            transition: transform 0.3s ease;
        }

        .footer-logo-desktop:hover {
            transform: scale(1.05);
        }

        /* Logo Mobile - LEBIH BESAR */
        .footer-logo-mobile {
            width: 140px;
            height: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        .footer-logo-mobile:hover {
            transform: scale(1.05);
        }

        /* Social Media Hover Effect */
        .footer-social-link {
            transition: transform 0.3s ease, opacity 0.3s ease;
            display: inline-block;
        }
        
        .footer-social-link:hover {
            transform: translateY(-3px);
            opacity: 0.8;
        }

        /* Fine-tune alignment */
        footer h5 {
            margin-bottom: 1rem;
        }

        footer .col-md-4 {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        /* Ensure vertical alignment */
        @media (min-width: 768px) {
            footer .row {
                min-height: 120px;
            }
        }

        /* Visitor Counter Styles */
        .visitor-counter {
            background: rgba(255,255,255,0.1);
            border-radius: 25px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .visitor-counter:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .visitor-icon {
            font-size: 20px;
            color: #d5c58a;
        }

        .visitor-label {
            font-size: 14px;
            font-weight: 600;
        }

        .visitor-count {
            font-size: 18px;
            font-weight: 800;
            color: #d5c58a;
        }

        @media (max-width: 576px) {
            .visitor-counter {
                padding: 8px 16px;
            }
            
            .visitor-icon {
                font-size: 18px;
            }
            
            .visitor-label {
                font-size: 13px;
            }
            
            .visitor-count {
                font-size: 16px;
            }
        }
    </style>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(to right, #1a6b8a, #003344);">
        <div class="container-fluid">

            <!-- LOGO + TEKS -->
            <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('images/LogoPKP.png')); ?>" alt="Logo PKP" height="40" class="me-2">
                <div>
                    <div style="font-size: 18px; line-height: 1.2; font-weight: 800; color: #d5c58a;">
                        PPID
                    </div>
                    <div style="font-size: 9px; font-weight: 800; line-height: 1.2;">
                        KEMENTERIAN PERUMAHAN DAN KAWASAN PERMUKIMAN<br>
                        REPUBLIK INDONESIA
                    </div>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: white;">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- Beranda -->
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('home')); ?>">
                            Beranda
                        </a>
                    </li>

                    <!-- Profil PPID -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?php echo e(request()->routeIs('profil.*') ? 'active' : ''); ?>" 
                           href="#" 
                           id="profilDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown">
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('profil.index')); ?>">Profil</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profil.struktur-organisasi')); ?>">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profil.dasar-hukum')); ?>">Dasar Hukum</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profil.tugas-fungsi')); ?>">Tugas & Fungsi</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profil.visi-misi')); ?>">Visi & Misi</a></li>
                        </ul>
                    </li>

                    <!-- Regulasi -->
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('regulasi.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('regulasi.index')); ?>">
                            Regulasi
                        </a>
                    </li>

                    <!-- Informasi Publik -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?php echo e(request()->routeIs('informasi-publik.*') || request()->routeIs('halaman-statis.*') ? 'active' : ''); ?>" 
                           href="#" 
                           role="button" 
                           data-bs-toggle="dropdown">
                            Informasi Publik
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('halaman-statis.show', 'informasi-berkala')); ?>">Informasi Berkala</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('halaman-statis.show', 'informasi-serta-merta')); ?>">Informasi Serta-Merta</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('halaman-statis.show', 'informasi-setiap-saat')); ?>">Informasi Setiap Saat</a></li>
                        </ul>
                    </li>

                    <!-- Standar Layanan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?php echo e(request()->routeIs('standar-layanan.*') ? 'active' : ''); ?>" 
                           href="#" 
                           role="button" 
                           data-bs-toggle="dropdown">
                            Standar Layanan
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                                $standarLayananMenu = \App\Models\StandarLayanan::where('is_active', true)
                                    ->orderBy('urutan')
                                    ->get();
                            ?>
                            
                            <?php $__empty_1 = true; $__currentLoopData = $standarLayananMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('standar-layanan.show', $menu->slug)); ?>">
                                        <?php echo e($menu->nama_layanan); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li><span class="dropdown-item text-muted">Belum ada halaman</span></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- FAQ -->
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('faq.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('faq.index')); ?>">
                            FAQ
                        </a>
                    </li>

                    <!-- Berita -->
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('berita.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('berita.index')); ?>">
                            Berita
                        </a>
                    </li>

                    <!-- Galeri -->
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('galeri.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('galeri.index')); ?>">
                            Galeri
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?php if(session('success')): ?>
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- FOOTER -->
    <footer class="text-white" style="background-color: #0a3d4a; padding: 40px 0;">
        <div class="container">
            
            <!-- Desktop Layout -->
            <div class="row d-none d-md-flex align-items-start">
                
                <!-- Logo & Brand - Kiri -->
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e(asset('images/LogoPKP.png')); ?>" 
                             alt="Logo" 
                             class="footer-logo-desktop me-3 flex-shrink-0">
                        <div>
                            <h5 class="mb-0" style="font-weight: 800; font-size: 20px; line-height: 1.2;">PPID</h5>
                            <p class="mb-0" style="font-size: 12px; line-height: 1.3; font-weight: 600;">
                                KEMENTERIAN PERUMAHAN<br>
                                DAN KAWASAN PERMUKIMAN<br>
                                REPUBLIK INDONESIA
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Alamat - Tengah -->
                <div class="col-md-4 text-center">
                    <h5 class="mb-3" style="font-weight: 700; font-size: 18px;">Alamat</h5>
                    <p class="mb-0" style="font-size: 14px; line-height: 1.6;">
                        Jl. Raden Patah 1, Selong,<br>
                        Kebayoran Baru, Jakarta Selatan
                    </p>
                </div>

                <!-- Hubungi Kami - Kanan -->
                <div class="col-md-4 text-end">
                    <h5 class="mb-3" style="font-weight: 700; font-size: 18px;">Hubungi Kami:</h5>
                    
                    <!-- WhatsApp -->
                    <div class="mb-3">
                        <a href="https://wa.me/6285975062727" target="_blank" class="text-white text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-whatsapp me-2" style="font-size: 24px;"></i>
                            <span style="font-size: 16px; font-weight: 600;">0859 7506 2727</span>
                        </a>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="#" class="text-white footer-social-link" style="font-size: 26px;"><i class="bi bi-globe"></i></a>
                        <a href="https://www.instagram.com/ppid.kemenpkp/" target="_blank" class="text-white footer-social-link" style="font-size: 26px;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white footer-social-link" style="font-size: 26px;"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="text-white footer-social-link" style="font-size: 26px;"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

            </div>

            <!-- Mobile Layout -->
            <div class="d-md-none">
                
                <!-- Logo & Brand -->
                <div class="text-center mb-4">
                    <img src="<?php echo e(asset('images/LogoPKP.png')); ?>" 
                         alt="Logo" 
                         class="footer-logo-mobile mb-3">
                    <div>
                        <h5 class="mb-1" style="font-weight: 800; font-size: 22px; line-height: 1.2;">PPID</h5>
                        <p class="mb-0" style="font-size: 13px; line-height: 1.4; font-weight: 600;">
                            KEMENTERIAN PERUMAHAN<br>
                            DAN KAWASAN PERMUKIMAN<br>
                            REPUBLIK INDONESIA
                        </p>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="text-center mb-4">
                    <h5 class="mb-2" style="font-weight: 700; font-size: 16px;">Alamat</h5>
                    <p class="mb-0" style="font-size: 13px; line-height: 1.5;">
                        Jl. Raden Patah 1, Selong,<br>
                        Kebayoran Baru, Jakarta Selatan
                    </p>
                </div>

                <!-- Hubungi Kami -->
                <div class="text-center">
                    <h5 class="mb-3" style="font-weight: 700; font-size: 16px;">Hubungi Kami:</h5>
                    
                    <!-- WhatsApp -->
                    <div class="mb-3">
                        <a href="https://wa.me/6285975062727" target="_blank" class="text-white text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-whatsapp me-2" style="font-size: 22px;"></i>
                            <span style="font-size: 15px; font-weight: 600;">0859 7506 2727</span>
                        </a>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="#" class="text-white footer-social-link" style="font-size: 24px;"><i class="bi bi-globe"></i></a>
                        <a href="https://www.instagram.com/ppid.kemenpkp/" target="_blank" class="text-white footer-social-link" style="font-size: 24px;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white footer-social-link" style="font-size: 24px;"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="text-white footer-social-link" style="font-size: 24px;"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

            </div>

            <!-- VISITOR COUNTER - Tampil di Desktop & Mobile -->
            <div class="row mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
                <div class="col-12">
                    <div class="text-center">
                        <div class="visitor-counter">
                            <i class="bi bi-eye visitor-icon"></i>
                            <span class="visitor-label">Total Pengunjung:</span>
                            <span class="visitor-count">
                                <?php
                                    try {
                                        $totalVisitors = \App\Models\Visitor::getTotalVisitors();
                                    } catch (\Exception $e) {
                                        $totalVisitors = 0;
                                    }
                                ?>
                                <?php echo e(number_format($totalVisitors, 0, ',', '.')); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        // Initialize GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            closeButton: true,
            zoomable: true,
            draggable: true
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\Kerjaan\PUSDATIN\ppid\resources\views/layouts/app.blade.php ENDPATH**/ ?>